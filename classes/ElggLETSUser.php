<?php
/**
 * Extended class to do easier the LETS management.
 */
class ElggLETSUser extends ElggUser {

	public function createAccount($container_guid){
		$group = new ElggLETSGroup($container_guid);
		if($group->isLETS() && $group->isMember($this->guid)){
			$account = new ElggLETSAccount($this->guid, $group->guid);
			$account->disabled = false;
			return $account->save();
		}
		return false;
	}
	
	public function deleteAccount($container_guid){
		$account = new ElggLETSAccount($this->guid, $container_guid);
		$account->disabled = true;
		return true;//TODO
	}
	
	public function hasAccount($container_guid){
		$group = new ElggLETSGroup($container_guid);
		return $group->isLETS() && $group->isMember($this->guid);
	}
}
