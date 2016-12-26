<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */

$guid = get_input('guid');
$entity = get_entity($guid);

if (!$entity || !elgg_instanceof($entity) || !$entity->canEdit()) {
    register_error(elgg_echo('amap_coverphoto:upload:fail'));
    forward(REFERER);
}

$error = elgg_get_friendly_upload_error($_FILES['cover']['error']);
if ($error) {
    register_error(elgg_echo('amap_coverphoto:upload:fail:image'));
    forward(REFERER);
}

$icon_sizes = elgg_get_config('cover_sizes');


// get the images and save their file handlers into an array
// so we can do clean up if one fails.
$files = array();

foreach ($icon_sizes as $name => $size_info) {
    //$size_info_h = 
    $resized = get_resized_image_from_uploaded_file('cover', $size_info['w'], $size_info['h'], $size_info['square'], $size_info['upscale']);

    if ($resized) {
        //@todo Make these actual entities.  See exts #348.
        $file = new CoverPhoto();
        $file->owner_guid = $guid;
        $file->setFilename("coverphoto/{$guid}{$name}.jpg");
        $file->open('write');
        $file->write($resized);
        $file->close();
        $files[] = $file;
    } else {
        // cleanup on fail
        foreach ($files as $file) {
            $file->delete();
        }

        register_error(elgg_echo('amap_coverphoto:resize:fail'));
        forward(REFERER);
    }
}

// reset crop coordinates
$entity->x1 = 0;
$entity->x2 = 0;
$entity->y1 = 0;
$entity->y2 = 0;

$entity->covertime = time();
$entity->save();
system_message(elgg_echo("amap_coverphoto:upload:success"));

forward(REFERER);
