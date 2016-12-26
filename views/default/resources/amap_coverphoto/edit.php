<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */

// Only logged in users
gatekeeper();

$guid = elgg_extract('guid', $vars, 0);
$entity = get_entity($guid);

if ($entity->canEdit()) {

    $title = elgg_echo('amap_coverphoto:edit');

    $content = elgg_view('amap_coverphoto/edit', array('entity' => $entity));

    //only offer the crop view if an cover has been uploaded
    if (isset($entity->covertime)) {
        $content .= elgg_view('amap_coverphoto/crop', array('entity' => $entity));
    }

    $content .= '<style type="text/css">
            .elgg-main {
            background-color: #fff
	}
	</style>';

    $params = array(
        'content' => $content,
        'title' => $title,
    );
    $body = elgg_view_layout('one_column', $params);

    echo elgg_view_page($title, $body);
} else {
    register_error(elgg_echo("amap_coverphoto:edit:notvalidaccess"));
    forward(REFERER);
}
