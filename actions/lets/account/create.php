<?php

$owner_guid = (int) get_input('owner');
$container_guid = (int) get_input('container');

$owner = new ElggLETSUser($owner_guid);

if($owner->createAccount($container_guid)){
	system_message(elgg_echo('lets:account:created'));
	//TODO add to river
} else {
	register_error(elgg_echo('lets:error:account:create'));
}

forward();
