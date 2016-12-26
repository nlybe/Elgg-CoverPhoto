<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 */

elgg_register_event_handler('init', 'system', 'amap_coverphoto_init');

define('AMAP_COVERPHOTO_GENERAL_YES', 'yes'); // general purpose string for yes
define('AMAP_COVERPHOTO_GENERAL_NO', 'no'); // general purpose string for no

require_once(dirname(__FILE__) . "/lib/hooks.php");

function amap_coverphoto_init() {
    require_once dirname(__FILE__) . '/lib/amap_coverphoto.php';

    // register extra css
    elgg_extend_view('elgg.css', 'amap_coverphoto/amap_coverphoto.css');
    elgg_extend_view('css/admin', 'amap_coverphoto/amap_coverphoto_admin.css');    

    // Register a page handler, so we can have nice URLs
    elgg_register_page_handler('coverphoto', 'amap_coverphoto_page_handler');

    // add option to entities menu for editing cover photo
    elgg_register_plugin_hook_handler('register', 'menu:entity', 'amap_coverphoto_entity_menu_setup', 400);

    // extend hover-over menu
    elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'amap_coverphoto_elgg_user_hover_menu');

    // extend JS
    elgg_register_js('cover_cropper', 'mod/amap_coverphoto/views/default/amap_coverphoto/ui.cover_cropper.js');

    // Register actions
    $action_path = elgg_get_plugins_path() . 'amap_coverphoto/actions/amap_coverphoto';
    elgg_register_action('amap_coverphoto/upload', "$action_path/upload.php");
    elgg_register_action("amap_coverphoto/crop", "$action_path/crop.php");
    elgg_register_action("amap_coverphoto/remove", "$action_path/remove.php");

    // set cover sizes
    elgg_set_config('cover_sizes', array(
        'tiny' => array('w' => 200, 'h' => 66, 'square' => FALSE, 'upscale' => FALSE),
        'small' => array('w' => 400, 'h' => 133, 'square' => FALSE, 'upscale' => FALSE),
        'medium' => array('w' => 900, 'h' => 300, 'square' => FALSE, 'upscale' => FALSE),
        'large' => array('w' => 1170, 'h' => 390, 'square' => FALSE, 'upscale' => FALSE),
        'master' => array('w' => 1300, 'h' => 1300, 'square' => FALSE, 'upscale' => FALSE),
    ));
}

/**
 *  Dispatches cover photo pages.
 *
 * @param array $page
 * @return bool
 */
function amap_coverphoto_page_handler($page) {

    if (!isset($page[0])) {
        $page[0] = 'all';
    }
    $vars = array();
    $vars['page'] = $page[0];

    $base = elgg_get_plugins_path() . 'amap_coverphoto/pages/amap_coverphoto';

    switch ($page[0]) {
        case "view":
            $resource_vars['guid'] = elgg_extract(1, $page);
            $resource_vars['size'] = elgg_extract(2, $page);
            echo elgg_view_resource('amap_coverphoto/view', $resource_vars);            
            break;
        case "edit":
            $resource_vars['guid'] = elgg_extract(1, $page);
            echo elgg_view_resource('amap_coverphoto/edit', $resource_vars);            
            break;
        case "graphics":
            return true;
            break;
        default:
            return false;
    }

    elgg_pop_context();
    return true;
}
