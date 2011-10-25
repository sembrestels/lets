<?php
/**
 * Local Exchange Trading Plugin plugin
 *
 */

elgg_register_event_handler('init', 'system', 'lets_init');

function lets_init() {
	add_group_tool_option('lets', elgg_echo('lets:enablelets'), false);
	elgg_extend_view('groups/tool_latest', 'lets/group_module');
}
