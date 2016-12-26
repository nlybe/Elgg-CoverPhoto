<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */

$guid = get_input('guid');
$entity = get_entity($guid);

if (!$entity || !elgg_instanceof($entity) || !$entity->canEdit()) {
    register_error(elgg_echo('amap_coverphoto:crop:fail'));
    forward(REFERER);
}

$x1 = (int) get_input('x1', 0);
$y1 = (int) get_input('y1', 0);
$x2 = (int) get_input('x2', 0);
$y2 = (int) get_input('y2', 0);

$filehandler = new CoverPhoto();
$filehandler->owner_guid = $entity->getGUID();
$filehandler->setFilename("coverphoto/" . $entity->guid . "master" . ".jpg");
$filename = $filehandler->getFilenameOnFilestore();

// ensuring the avatar image exists in the first place
if (!file_exists($filename)) {
    register_error(elgg_echo('amap_coverphoto:crop:fail'));
    forward(REFERER);
}

$icon_sizes = elgg_get_config('cover_sizes');
unset($icon_sizes['master']);

// get the images and save their file handlers into an array
// so we can do clean up if one fails.
$files = array();
foreach ($icon_sizes as $name => $size_info) {
    $resized = get_resized_image_from_existing_file($filename, $size_info['w'], $size_info['h'], $size_info['square'], $x1, $y1, $x2, $y2, $size_info['upscale']);

    if ($resized) {
        $file = new CoverPhoto();
        $file->owner_guid = $guid;
        $file->setFilename("coverphoto/{$guid}{$name}.jpg");
        $file->open('write');
        $file->write($resized);
        $file->close();
        $files[] = $file;
    } 
    else {
        // cleanup on fail
        foreach ($files as $file) {
            $file->delete();
        }

        register_error(elgg_echo('amap_coverphoto:resize:fail'));
        forward(REFERER);
    }
}

// check if cover size has been entered in setting
$entity_type = getEntityCoverType($entity);
$width = elgg_get_plugin_setting('amap_coverphoto_'.$entity_type.'_w', 'amap_coverphoto');
$height = elgg_get_plugin_setting('amap_coverphoto_'.$entity_type.'_h', 'amap_coverphoto');
if (is_numeric($width) && is_numeric($width)) {
    $resized = get_resized_image_from_existing_file($filename, $width, $height, false, $x1, $y1, $x2, $y2, false);

    if ($resized) {
        $file = new CoverPhoto();
        $file->owner_guid = $guid;
        $file->setFilename("coverphoto/{$guid}{$entity_type}.jpg");
        $file->open('write');
        $file->write($resized);
        $file->close();
        $files[] = $file;
    }    
}

$entity->covertime = time();

$entity->x1 = $x1;
$entity->x2 = $x2;
$entity->y1 = $y1;
$entity->y2 = $y2;

$entity->save();

system_message(elgg_echo('amap_coverphoto:crop:success'));
forward(REFERER);
