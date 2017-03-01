<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */

echo elgg_view_input('file', [
    'name' => 'cover',
    'label' => elgg_echo("amap_coverphoto:upload"),
    'help' => elgg_echo("amap_coverphoto:upload:help"),
]);

?>

<div class="elgg-foot">
    <?php echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['entity']->guid)); ?>
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('upload'))); ?>
</div>
