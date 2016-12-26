<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */

/**
 * Get cover image of given entity
 * @param type $entity
 * @param type $size
 * @return boolean
 */
function amap_cp_getCoverIconUrl($entity, $size = 'medium') {

    if (!elgg_instanceof($entity))
        return false;

    $icon_time = $entity->covertime;
    if ($icon_time) {
        $cover_url = "coverphoto/view/$entity->guid/$size/$icon_time";
    } else {
        $cover_url = "mod/amap_coverphoto/graphics/cover/{$size}.jpg";
    }

    return elgg_normalize_url($cover_url);
}

/**
 * Determine the entity identifier in order to retreive custom size, if available
 * 
 * @param type $entity
 * @return type
 */
function getEntityCoverType($entity) {
    if (($entity instanceof \ElggUser) || ($entity instanceof \ElggGroup)) 
        $entity_type = $entity->getType();
    else 
        $entity_type = $entity->getSubtype();

    return $entity_type;
}