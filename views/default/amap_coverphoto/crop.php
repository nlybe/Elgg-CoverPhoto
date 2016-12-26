<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */

?>

<div id="avatar-croppingtool" class="mtl ptm">	
    <?php 
        echo elgg_format_element('h2', [], elgg_echo("amap_coverphoto:create:instructions:title")); 
        echo elgg_format_element('p', [], elgg_echo("amap_coverphoto:create:instructions")); 
        echo elgg_view_form('amap_coverphoto/crop', array(), $vars); 
    ?>
</div>
