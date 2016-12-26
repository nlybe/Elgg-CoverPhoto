<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */
 
$language = array(

    'amap_coverphoto' => 'Upload cover photo to Entities',
    
    // general
    'amap_coverphoto:edit' => 'Cover Photo',  
    'amap_coverphoto:edit:cover' => 'Edit cover',   
    'amap_coverphoto:edit:cover:add' => 'Add cover photo',   
    'amap_coverphoto:edit:notvalidaccess' => 'Not valid access', 
    'amap_coverphoto:back:entity' => 'Back to view',
    
    // edit cover
    'amap_coverphoto:current' => 'Current cover',  
    'amap_coverphoto:upload' => 'Upload an image',
    'amap_coverphoto:upload:fail' => 'Failed to upload the file',
    'amap_coverphoto:upload:fail:image' => 'Not valid image file',
    'amap_coverphoto:resize:fail' => 'Failed to resized the cover',
    'amap_coverphoto:crop:fail' => 'Failed to crop the cover',
    'amap_coverphoto:crop:success' =>  'The cover was published correctly',
    'amap_coverphoto:upload:success' => 'The cover was uploaded correctly',
    'amap_coverphoto:remove:fail' => 'Error removing the cover',
    'amap_coverphoto:remove:success' => 'You have successfully deleted the cover',
    'amap_coverphoto:upload:instructions:title' =>'Step 1',
    'amap_coverphoto:upload:instructions' =>'Upload an image of at least 1300px width.',
    'amap_coverphoto:create:instructions:title' => "Step 2",
    'amap_coverphoto:create:instructions' => "Click and drag a square below to match how you want your cover cropped. When you are happy with the area, click on <strong>Crop</strong> button.",
    'amap_coverphoto:crop:create' => 'Crop',
    'amap_coverphoto:crop:fail' => 'Failed to crop the cover',
    'amap_coverphoto:crop:success' =>  'The cover was published correctly',  
    'amap_coverphoto:remove:success' => 'You have successfully deleted the cover',
    
    // settings
    'amap_coverphoto:settings:basic_settings:intro' => 'Select entities for which you want to enable cover photo and the size of cover image for each entity',
    'amap_coverphoto:settings:no' => "No",
    'amap_coverphoto:settings:yes' => "Yes",    
    'amap_coverphoto:settings:width' => "Width",    
    'amap_coverphoto:settings:height' => "Height",    
    
);

add_translation('en', $language);
