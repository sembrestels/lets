<?php
/**
 * Local Exchange Trading Plugin plugin
 *
 */

elgg_register_event_handler('init', 'system', 'lets_init');

function lets_init() {
	
	// routing of urls
	elgg_register_page_handler('lets', 'lets_page_handler');
	
	// add LETS link to
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'lets_owner_block_menu');
	//TODO moderate by site admins option
	add_group_tool_option('lets', elgg_echo('lets:enablelets'), false);
	elgg_extend_view('groups/tool_latest', 'lets/group_module');
	
	// register actions
	$action_path = elgg_get_plugins_path() . 'lets/actions/lets';
	elgg_register_action('lets/account/create', "$action_path/account/create.php");
	elgg_register_action('lets/account/delete', "$action_path/account/delete.php");
	elgg_register_action('lets/transfer', "$action_path/transfer.php");
	
	// entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'lets_entity_menu_setup');
}

function lets_page_handler($page){
	
	$page_type = $page[0];
	
	switch($page_type){
		case 'group':
			$title = elgg_echo('lets:group');
			$params = array(
				'title' => $title,
				'filter' => '',
			);
			break;
		case 'transfer':
			$to_guid = $page[1];
			$container_guid = $page[2];
			
			$to = new ElggLETSUser($to_guid);
			
			if($to->hasAccount($container_guid)){
				elgg_set_page_owner_guid($to->guid);
				$content = elgg_view_form('lets/transfer', array(), array('currency' => $container_guid));
			} else {
				$content = elgg_echo('lets:error');
			}
			
			$title = elgg_echo('lets:transfer');
			$params = array(
				'title' => $title,
				'content' => $content,
				'filter' => '',
			);
	}
	
	$params['sidebar'] .= elgg_view('lets/sidebar', array('page' => $page_type));

	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($params['title'], $body);
}

/**
 * Add a menu item to an ownerblock
 */
function lets_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "lets/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('lets', elgg_echo('lets'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->lets_enable == "yes") {
			$url = "lets/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('blog', elgg_echo('lets:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Add particular blog links/info to entity menu
 */
function lets_entity_menu_setup($hook, $type, $return, $params) {
	
	$entity = $params['entity'];//var_dump($entity);
	
	if($entity->getType() == 'object' && $entity->getSubtype() == 'lets-account'){
		$account = new ElggLETSAccount($entity->guid);
		if ($account->canTransfer()) {
			$options = array(
				'name' => 'transfer',
				'text' => elgg_echo('lets:transfer'),
				'href' => "lets/transfer/$entity->guid/$entity->container_guid",
				'priority' => 150,
			);
			$return[] = ElggMenuItem::factory($options);
		}
		
		$to_remove = array('edit', 'delete', 'likes');
		foreach($return as $i => $item){
			if(in_array($item->getName(), $to_remove)){
				unset($return[$i]);
			}
		}
	}

	return $return;
}
