<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */

$plugin = elgg_get_plugin_from_id('amap_coverphoto');

$potential_yes_no = array(
    elgg_echo('amap_coverphoto:settings:yes') => AMAP_COVERPHOTO_GENERAL_YES,
    elgg_echo('amap_coverphoto:settings:no') => AMAP_COVERPHOTO_GENERAL_NO,
);

//print_r(get_registered_entity_types());
$types = get_registered_entity_types();

$output = elgg_format_element(
    'div', 
    ['style' => 'margin: 0 0 15px;'], 
    elgg_echo('amap_coverphoto:settings:basic_settings:intro'
));
foreach ($types as $key => $t) {

    if ($key == 'user' || $key == 'group') {
        $tmp = elgg_format_element('div', [], elgg_format_element('strong', [], $key));
        
        $param_name_entity = 'amap_coverphoto_' . $key;
        $param_name = 'params[' . $param_name_entity . ']';
        $tmp .= elgg_view_input('radio', array(
            'name' => $param_name, 
            'value' => $plugin->$param_name_entity, 
            'options' => $potential_yes_no, 
            'align' => 'horizontal'
        ));
        
        $param_name_entity_w = $param_name_entity.'_w';
        $param_name_w = 'params[' . $param_name_entity_w . ']';
        $tmp .= elgg_view_input('text', array(
            'name' => $param_name_w, 
            'value' => $plugin->$param_name_entity_w, 
            'placeholder' => elgg_echo('amap_coverphoto:settings:width'), 
            'class' => 'cover_width', 
        ));
        
        $param_name_entity_h = $param_name_entity.'_h';
        $param_name_h = 'params[' . $param_name_entity_h . ']';
        $tmp .= elgg_view_input('text', array(
            'name' => $param_name_h, 
            'value' => $plugin->$param_name_entity_h, 
            'placeholder' => elgg_echo('amap_coverphoto:settings:height'), 
            'class' => 'cover_height', 
        ));        
        
        $tmp .= elgg_format_element('span', ['class' => 'elgg-subtext'], '');
        
        $line = elgg_format_element('div', ['class' => 'cover_box'], $tmp);
        $output .= elgg_view_module("inline", '', $line);
    } 
    else {
        if ($key == 'object') {
            $sub_arr = $t;

            foreach ($sub_arr as $sub) {
                $tmp = elgg_format_element('div', [], elgg_format_element('strong', [], $sub));
                
                $param_name_entity = 'amap_coverphoto_' . $sub;
                $param_name = 'params[' . $param_name_entity . ']';
                $tmp .= elgg_view_input('radio', array(
                    'name' => $param_name, 
                    'value' => $plugin->$param_name_entity, 
                    'options' => $potential_yes_no, 
                    'align' => 'horizontal'
                ));
                
                $param_name_entity_w = $param_name_entity.'_w';
                $param_name_w = 'params[' . $param_name_entity_w . ']';
                $tmp .= elgg_view_input('text', array(
                    'name' => $param_name_w, 
                    'value' => $plugin->$param_name_entity_w, 
                    'placeholder' => elgg_echo('amap_coverphoto:settings:width'), 
                    'class' => 'cover_width', 
                ));

                $param_name_entity_h = $param_name_entity.'_h';
                $param_name_h = 'params[' . $param_name_entity_h . ']';
                $tmp .= elgg_view_input('text', array(
                    'name' => $param_name_h, 
                    'value' => $plugin->$param_name_entity_h, 
                    'placeholder' => elgg_echo('amap_coverphoto:settings:height'), 
                    'class' => 'cover_height', 
                ));                
                $tmp .= elgg_format_element('span', ['class' => 'elgg-subtext'], '');
                
                $line = elgg_format_element('div', ['class' => 'cover_box'], $tmp);
                $output .= elgg_view_module("inline", '', $line);
            }
        }
    }
}

echo elgg_view_module("inline", elgg_echo(''), $output);
