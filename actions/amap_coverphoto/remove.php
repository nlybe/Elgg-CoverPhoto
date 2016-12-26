<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */

$guid = get_input('guid');
$entity = get_entity($guid);

if (!$entity || !$entity->canEdit()) {
    register_error(elgg_echo('amap_coverphoto:remove:fail'));
    forward(REFERER);
}

// Delete all icons from diskspace
$icon_sizes = elgg_get_config('cover_sizes');

foreach ($icon_sizes as $name => $size_info) {
    $file = new CoverPhoto();
    $file->owner_guid = $entity->guid;
    $file->setFilename("coverphoto/{$entity->guid}{$name}.jpg");
    $filepath = $file->getFilenameOnFilestore();
    if (!$file->delete()) {
        elgg_log("Cover file remove failed. Remove $filepath manually, please.", 'WARNING');
    }
}

// Remove crop coords
unset($entity->x1);
unset($entity->x2);
unset($entity->y1);
unset($entity->y2);

// Remove icon  entry
unset($entity->covertime);

system_message(elgg_echo('amap_coverphoto:remove:success'));
forward(REFERER);
