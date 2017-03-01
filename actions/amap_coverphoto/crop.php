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
$filehandler->setFilename("coverphoto/" . $entity->getGUID() . "master" . ".jpg");
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
    
    $image = new CoverPhoto();
    $image->owner_guid = $entity->getGUID();
    $image->setFilename("coverphoto/{$entity->getGUID()}{$name}.jpg");
    $image->open('write');
    $image->close();

    $resized = elgg_save_resized_image($filename, $image->getFilenameOnFilestore(), array(
        'w' => $size_info['w'],
        'h' => $size_info['h'],
        'x1' => $x1,
        'y1' => $y1,
        'x2' => $x2,
        'y2' => $y2,
        'square' => $size_info['square'],
        'upscale' => $size_info['upscale'],
    ));           

    if ($resized) {
        $files[] = $file;
    } else {
        // cleanup on fail
        foreach ($files as $file) {
            $file->delete();
        }

        register_error(elgg_echo('amap_coverphoto:resize:fail'));
        forward(REFERER);
    }
    
    unset($resized);     
}

// check if cover size has been entered in setting
$entity_type = getEntityCoverType($entity);
$width = elgg_get_plugin_setting('amap_coverphoto_'.$entity_type.'_w', 'amap_coverphoto');
$height = elgg_get_plugin_setting('amap_coverphoto_'.$entity_type.'_h', 'amap_coverphoto');
if (is_numeric($width) && is_numeric($width)) {
    
    $image = new CoverPhoto();
    $image->owner_guid = $entity->getGUID();
    //$image->container_guid = $entity->getGUID();
    $image->setFilename("coverphoto/{$entity->getGUID()}{$entity_type}.jpg");
    $image->open('write');
    $image->close();
    
    $resized = elgg_save_resized_image($filename, $image->getFilenameOnFilestore(), array(
        'w' => $width,
        'h' => $height,
        'x1' => $x1,
        'y1' => $y1,
        'x2' => $x2,
        'y2' => $y2,
        'square' => false,
        'upscale' => false,
    ));  
    
    unset($resized); 
}

$entity->covertime = time();

$entity->x1 = $x1;
$entity->x2 = $x2;
$entity->y1 = $y1;
$entity->y2 = $y2;

$entity->save();
//error_log('lalala: '.$entity->x1.' - '.$entity->x2.' - '.$entity->y1.' - '.$entity->y2);

system_message(elgg_echo('amap_coverphoto:crop:success'));
forward(REFERER);
