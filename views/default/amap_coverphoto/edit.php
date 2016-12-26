<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */

$cover_imagen = elgg_view('output/img', array(
	'src' => amap_cp_getCoverIconUrl($vars['entity'], 'small'),
	'alt' => elgg_echo('cover'),
));

$current_label = elgg_echo('amap_coverphoto:current');

$remove_button = '';
if ($vars['entity']->covertime) {
	$remove_button = elgg_view('output/url', array(
		'text' => elgg_echo('remove'),
		'title' => elgg_echo('avatar:remove'),
		'href' => 'action/amap_coverphoto/remove?guid=' . $vars['entity']->getGUID(),
		'is_action' => true,
		'class' => 'elgg-button elgg-button-cancel',
	));
}

$form_params = array('enctype' => 'multipart/form-data');
$upload_form = elgg_view_form('amap_coverphoto/upload', $form_params, $vars);


echo elgg_format_element('h2', [], elgg_echo("amap_coverphoto:upload:instructions:title")); 
echo elgg_format_element('p', ['class' => 'mtm'], elgg_echo("amap_coverphoto:upload:instructions")); 
    

$image = <<<HTML
<div id="current-user-avatar" class="mrl prl">
	<label>$current_label</label><br />
	$cover_imagen
</div>
<div class="remove_button">$remove_button</div>
HTML;

$body = <<<HTML
<div id="avatar-upload">
	$upload_form
</div>
HTML;

echo elgg_view_image_block($image, $upload_form);
