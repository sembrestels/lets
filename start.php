<?php
/**
 * Local Exchange Trading Plugin plugin
 *
 */

elgg_register_event_handler('init', 'system', 'lets_init');

function lets_init() {
	
	// routing of urls
	elgg_register_page_handler('lets', 'lets_page_handler');
	
	add_group_tool_option('lets', elgg_echo('lets:enablelets'), false);
	elgg_extend_view('groups/tool_latest', 'lets/group_module');
}

function lets_page_handler($page){
	
	switch($page[0]){
		case 'group':
			$title = elgg_echo('lets:group');
			$params = array(
				'filter' => '',
			);
			break;
	}
	
	$params['sidebar'] .= elgg_view('lets/sidebar', array('page' => $page_type));

	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($params['title'], $body);
}
