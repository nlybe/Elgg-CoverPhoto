<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */
?>

<div>
	<label><?php echo elgg_echo("amap_coverphoto:upload"); ?></label><br />
	<?php echo elgg_view("input/file", array('name' => 'cover')); ?>
</div>
<div class="elgg-foot">
	<?php echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['entity']->guid)); ?>
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('upload'))); ?>
</div>
