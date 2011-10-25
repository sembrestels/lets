<?php

$concept = sanitize_string(get_input('concept'));
$amount = (float) get_input('amount');
$currency = (int) get_input('currency');
$to = (int) get_input('to');

$account = new ElggLETSAccount($to, $currency);

if($account->transfer($amount)){
	system_message(elgg_echo('lets:transfered'));
	$annotation = elgg_echo('lets:transfered:annotation');
	$account->annotate('transfer_history', $annotation, $account->access_id, elgg_get_logged_in_user_guid());
	//TODO add to river
} else {
	register_error(elgg_echo('lets:tranfer:error'));
}

forward();
