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

$uploaded_files = elgg_get_uploaded_files('cover');
if (!$uploaded_files) {
    register_error(elgg_echo('amap_coverphoto:upload:empty'));
    forward(REFERER);
}

$uploaded_file = array_shift($uploaded_files);
if (!$uploaded_file->isValid()) {
    $error = elgg_get_friendly_upload_error($uploaded_file->getError());
    register_error($error);
    forward(REFERER);
}

$supported_mimes = [
    'image/jpeg',
    'image/png',
    'image/gif',
];

$mime_type = ElggFile::detectMimeType($uploaded_file->getPathname(), $uploaded_file->getClientMimeType());
if (!in_array($mime_type, $supported_mimes)) {
    register_error(elgg_echo('amap_coverphoto:upload:invalid_file_type', array($mime_type)));
    forward(REFERER);
}

$icon_sizes = elgg_get_config('cover_sizes');

// get the images and save their file handlers into an array
// so we can do clean up if one fails.
$files = array();
foreach ($icon_sizes as $name => $size_info) {
    
    $image = new CoverPhoto();
    $image->owner_guid = $guid;
    $image->setFilename("coverphoto/{$guid}{$name}.jpg");
    $image->open('write');
    $image->close();

    $resized = elgg_save_resized_image($uploaded_file->getPathname(), $image->getFilenameOnFilestore(), array(
        'w' => $size_info['w'],
        'h' => $size_info['h'],
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

// reset crop coordinates
$entity->x1 = 0;
$entity->x2 = 0;
$entity->y1 = 0;
$entity->y2 = 0;

$entity->covertime = time();
$entity->save();
system_message(elgg_echo("amap_coverphoto:upload:success"));

forward(REFERER);
