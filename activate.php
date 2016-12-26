<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */

$subtypes = array(
    'coverphoto' => 'CoverPhoto',
);

foreach ($subtypes as $subtype => $class) {
    if (!update_subtype('object', $subtype, $class)) {
        add_subtype('object', $subtype, $class);
    }
}
