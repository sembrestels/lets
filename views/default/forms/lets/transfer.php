<?php
/**
 * LETS transfer form
 *
 * @package ElggLETS
 */


$concept_label = elgg_echo('lets:concept');
$concept_input = elgg_view('input/text', array(
	'name' => 'concept',
	'id' => 'lets_concept',
));

$amount_label = elgg_echo('lets:amount');
$amount_input = elgg_view('input/text', array(
	'name' => 'amount',
	'id' => 'lets_amount',
));

$currency_input = elgg_view('input/dropdown', array(
	'name' => 'currency',
	'id' => 'lets_currency',
	'value' => elgg_get_page_owner_guid(),
	'options_values' => array()
));

$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', array(
	'name' => 'access_id',
	'id' => 'blog_access_id',
	'value' => $vars['access_id']
));

$transfer_button = elgg_view('input/submit', array(
	'value' => elgg_echo('lets:transfer'),
	'name' => 'transfer',
));

echo <<<___HTML
<div>
	<label for="lets_concept">$concept_label</label>
	$concept_input
</div>

<div>
	<label for="lets_amount">$amount_label</label>
	$amount_input
	$currency_input
</div>

<div>
	<label for="lets_access_id">$access_label</label>
	$access_input
</div>

<div class="elgg-foot">
	$action_buttons
</div>

___HTML;
