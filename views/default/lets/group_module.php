<?php
/**
 * Group LETS module
 */

$group = elgg_get_page_owner_entity();

if ($group->lets_enable != "yes") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "lets/group/$group->guid/all",
	'text' => elgg_echo('link:view:all'),
));

elgg_push_context('widgets');
$content = "";
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('lets:none') . '</p>';
}

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('lets:group'),
	'content' => $content,
	'all_link' => $all_link,
));
