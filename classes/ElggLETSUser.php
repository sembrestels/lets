<?php
/**
 * Extended class to do easier the LETS management.
 */
class ElggLETSUser extends ElggUser {

	public function createAccount($container_guid){
		$group = new ElggLETSGroup($container_guid);
		if($group->isLETS() && $group->isMember($this->guid)){
			if(add_entity_relationship($this->guid, 'accept_currency', $group->guid)){
				$account = new ElggLETSAccount($this->guid, $group->guid);
				return $account->save();
			}
		}
		return false;
	}
	
	public function deleteAccount($container_guid){
		if(check_entity_relationship($this->guid, 'accept_currency', $container_guid)){
			return remove_entity_relationship($this->guid, 'accept_currency', $container_guid);
		}
		return false;
	}
	
	public function hasAccount($container_guid){
		$group = new ElggLETSGroup($container_guid);
		return $group->isLETS()
			&& $group->isMember($this->guid)
			&& check_entity_relationship($this->guid, 'accept_currency', $group->guid);
	}
	
	public function getAmount($container_guid){
		if($this->hasAccount($container_guid)){
			$account = new ElggLETSAccount($this->guid, $container_guid);
			return $account->amount;
		} else {
			return 0;
		}
	}
}
