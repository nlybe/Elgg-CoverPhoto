<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */

$entity = $vars['entity'];

$entity_type = getEntityCoverType($entity);
$width = elgg_get_plugin_setting('amap_coverphoto_'.$entity_type.'_w', 'amap_coverphoto');
$height = elgg_get_plugin_setting('amap_coverphoto_'.$entity_type.'_h', 'amap_coverphoto');

$entity_btn = elgg_view('input/button', array(
    'value' => elgg_echo('amap_coverphoto:back:entity'), 
    'class' => 'elgg-button elgg-button-submit entity_link',
    'onclick' => "location.href='".$entity->getURL()."'",
));
$crop_btn = elgg_view('input/submit', array(
    'value' => elgg_echo('amap_coverphoto:crop:create'), 
    'class' => 'elgg-button elgg-button-submit'
));
$buttons = $entity_btn . $crop_btn;

echo elgg_format_element('div', ['style' => 'padding: 10px 0;'], $buttons);

if (elgg_is_active_plugin('cropper')) {
    $master_img = elgg_view('output/img', array(
        'src' => amap_cp_getCoverIconUrl($entity, 'master'),
        'alt' => elgg_echo('cover'),
        'class' => 'mrl',
        'id' => 'image',
    ));

    $vars['image_to_crop'] = $master_img;
    if (intval($width)>0 && intval($height)>0) {
        $vars['aspectratio'] = intval($width)/intval($height);
    }
    echo elgg_view_input('cropper', $vars);
}
else {
    elgg_load_js('jquery.imgareaselect');
    elgg_load_js('cover_cropper');
    elgg_load_css('jquery.imgareaselect'); 
    
    $master_img = elgg_view('output/img', array(
        'src' => amap_cp_getCoverIconUrl($entity, 'master'),
        'alt' => elgg_echo('cover'),
        'class' => 'mrl',
        'id' => 'user-cover-cropper',
    ));    
    
    echo elgg_format_element('div', ['class' => 'clearfix'], $master_img);
    
    $footer .= elgg_view('input/hidden', array('name' => 'width', 'value' => $width));
    $footer .= elgg_view('input/hidden', array('name' => 'height', 'value' => $height));    
}

$coords = array('x1', 'x2', 'y1', 'y2');
foreach ($coords as $coord) {
    $footer .= elgg_view('input/hidden', array('name' => $coord, 'value' => $entity->$coord));
}
$footer .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $entity->guid));
$footer .= elgg_format_element('div', ['style' => 'padding: 10px 0;'], $buttons);  
echo elgg_format_element('div', ['class' => 'elgg-foot'], $footer);     
?>

