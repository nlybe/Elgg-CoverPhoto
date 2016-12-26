<?php
/**
 * Upload cover photo to Elgg Entities
 * @package amap_coverphoto 
 *
 * All hooks are here
 */

/**
 * Add option to entities menu for editing cover photo
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 * @return type
 */
function amap_coverphoto_entity_menu_setup($hook, $type, $return, $params) {
    if (elgg_is_logged_in()) {
        $entity = $params['entity'];

        if (!elgg_instanceof($entity, 'user') && !elgg_instanceof($entity, 'group')) {

            $entity_cover_setting = elgg_get_plugin_setting('amap_coverphoto_' . $entity->getSubtype(), 'amap_coverphoto');

            if ($entity->canEdit() && $entity_cover_setting == AMAP_COVERPHOTO_GENERAL_YES) {

                $url = elgg_normalize_url("coverphoto/edit/" . $entity->guid);

                $options = array(
                    'name' => 'editcoverphoto',
                    'text' => elgg_echo("amap_coverphoto:edit"),
                    'href' => $url,
                    'priority' => 400,
                );
                $return[] = ElggMenuItem::factory($options);
            }
        }
    }

    return $return;
}

/**
 * Add option to users for editing cover photo
 * 
 * @param type $type
 * @param type $subtype
 * @param type $return_value
 * @param type $params
 * @return \ElggMenuItem
 */
function amap_coverphoto_elgg_user_hover_menu($type, $subtype, $return_value, $params) {

    if (elgg_is_logged_in()) {
        $entity = $params['entity'];

        $entity_cover_setting = elgg_get_plugin_setting('amap_coverphoto_user', 'amap_coverphoto');

        if (elgg_instanceof($entity, 'user') && $entity->canEdit() && $entity_cover_setting == AMAP_COVERPHOTO_GENERAL_YES) {
            $url = elgg_normalize_url("coverphoto/edit/" . $entity->guid);

            //$url = elgg_add_action_tokens_to_url($url);	
            $menuItem = new ElggMenuItem('editcoverphoto', elgg_echo('amap_coverphoto:edit:cover'), $url);
            $menuItem->setSection('action');
            $return_value [] = $menuItem;
        }
    }

    return $return_value;
}
