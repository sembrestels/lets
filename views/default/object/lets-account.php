<?php
/**
 * View for LETS' Accounts objects
 *
 * @package ElggLETS
 */

$full = elgg_extract('full_view', $vars, FALSE);
$account = elgg_extract('entity', $vars, FALSE);
$account = new ElggLETSAccount($account->guid);

if (!$account) {
	return TRUE;
}

$owner = $account->getOwnerEntity();
$container = $account->getContainerEntity();

$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array(
	'href' => $account->getURL(),
	'text' => $owner->name,
));

$subtitle = elgg_view('output/amount', array('value' => $account->amount));

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'lets-account',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));


if ($full) {

	$body;

	$header = elgg_view_title(elgg_echo('lets:account:owner', array($owner->name)));

	$params = array(
		'entity' => $account,
		'title' => false,
		'metadata' => $metadata,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	$account_info = elgg_view_image_block($owner_icon, $list_body);

	echo <<<HTML
$header
$account_info
$body
HTML;

} else {
	// brief view

	$params = array(
		'entity' => $account,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'title' => $owner_link,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($owner_icon, $list_body);
}
