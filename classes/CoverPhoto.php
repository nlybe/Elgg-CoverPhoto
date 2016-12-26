<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */

class CoverPhoto extends ElggFile {

    const SUBTYPE = "coverphoto";

    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes["subtype"] = self::SUBTYPE;
    }

    Public function getImageUrl($size) {
        return false;
    }

}
