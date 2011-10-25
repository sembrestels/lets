<?php

$owner_guid = (int) get_input('owner');
$container_guid = (int) get_input('container');

$owner = new ElggLETSUser($owner_guid);

if($owner->deleteAccount($container_guid)){
	system_message(elgg_echo('lets:account:deleted'));
	//TODO add to river
} else {
	register_error(elgg_echo('lets:error:account:delete'));
}

forward(REFERER);
