<?php
/**
 * Extended class to do easier the LETS management.
 */
class ElggLETSUser extends ElggUser {

	public function createAccount($container_guid){
		$group = new ElggGroup($container_guid);
		if($group->lets_enable == 'yes' && $group->isMember($this->guid)){
			return add_entity_relationship($this->guid, 'accept_currency', $group->guid);
		} else {
			return false;
		}
	}
	
	public function deleteAccount($container_guid){
		if(check_entity_relationship()){
			remove_entity_relationship($this->guid, 'accept_currency', $container_guid);
		}
	}
	
	public function hasAccount($container_guid){
		$group = new ElggGroup($container_guid);
		return $group->lets_enable == 'yes'
			&& $group->isMember($this->guid);
			&& check_entity_relationship($guid, 'accept_currency', $group->guid);
	}
}
