<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */

$guid = elgg_extract('guid', $vars, 0);
$entity = get_entity($guid);

// Get the size
$size = strtolower(elgg_extract('size', $vars, 0));
if (in_array($size, array('master', 'large', 'medium', 'small', 'tiny'))) {
    // do nothing
}
else {
    // check if cover size has been entered in setting assuming that the size is equal with type or subtype of entity
    $width = elgg_get_plugin_setting('amap_coverphoto_'.$size.'_w', 'amap_coverphoto');
    $height = elgg_get_plugin_setting('amap_coverphoto_'.$size.'_h', 'amap_coverphoto');
    if (!is_numeric($width) || !is_numeric($width)) {
        $size = 'medium';
    }
}

// If entity doesn't exist, return default icon
if (!$entity) {
    $url = elgg_normalize_url("_graphics/icons/default/{$size}.png");
    forward($url);
}
$entity_guid = $entity->getGUID();

// Try and get the icon
$filehandler = new CoverPhoto();
$filehandler->owner_guid = $entity_guid;
$filehandler->setFilename("coverphoto/{$entity_guid}{$size}.jpg");

$success = false;

try {
    if ($filehandler->open("read")) {
        //if ($contents = $filehandler->read($filehandler->getSize())) {  // (1.9)
        if ($contents = $filehandler->read($filehandler->size())) {
            $success = true;
        }
    }
} catch (InvalidParameterException $e) {
    elgg_log("Unable to get cover for user with GUID $entity->guid", 'ERROR');
}


if (!$success) {
    $url = "_graphics/icons/default/{$size}.png";
    $url = elgg_normalize_url($url);
    forward($url);
}

header("Content-type: image/jpeg", true);
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
header("Pragma: public", true);
header("Cache-Control: public", true);
header("Content-Length: " . strlen($contents));

echo $contents;
