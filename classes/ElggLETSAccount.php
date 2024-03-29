<?php
/**
 * Extended class to do easier the LETS management.
 */
class ElggLETSAccount extends ElggObject {
	
	public function __construct(int $owner_guid, int $container_guid = NULL){
		
		$account_guid = self::getAccountGUID($owner_guid, $container_guid);
		$owner = get_entity($owner_guid);
		error_log($account_guid);
		if($account_guid){
			parent::__construct($account_guid);
			
		} elseif($owner && $owner->getType() == 'object' && $owner->getSubtype() == 'lets-account') {
			parent::__construct($owner->guid);
		
		} else {
			parent::__construct();
			$this->set('owner_guid', $owner_guid);
			$this->set('container_guid', $container_guid);
			$this->set('access_id', get_entity($container_guid)->group_acl);
		}
			
	}
	
	/**
	 * Set subtype to account.
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "lets-account";
	}
	
	protected static function getAccountGUID(int $owner_guid, int $container_guid){
		$entities = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'lets-account',
			'owner_guid' => $owner_guid,
			'container_guid' => $container_guid,
			'limit' => 1,
		));
		if(count($entities) > 0) {
			return (int) $entites[0]->getGUID();
			//FIXME it is a non-object when creating by second time an account
		} else {
			return false;
		}
	}
	
	public function canTransfer($guid = NULL){
		if(!$guid){
			$guid = elgg_get_logged_in_user_guid();
		}
		
		$user = new ElggLETSUser($guid);
		
		return $user->hasAccount($this->container_guid);
	}
	
	public function transfer($quantity, $from = NULL){
		if(!$from){
			$from = new ElggLETSAccount(elgg_get_logged_in_user_entity()->username, $this->container_guid);
		}
		
		$previous_ia = elgg_set_ignore_access(true);
		
		$from->amount -= $quantity;
		$this->amount += $quantity;
		
		$from->save();
		$this->save();
		
		elgg_set_ignore_access($previous_ia);
	}
	
	public function getURL(){
		$owner_username = get_entity($this->owner_guid)->username;
		return elgg_get_site_url() . "lets/account/$owner_username/$this->container_guid/";
	}
	
	public function getTransferURL(){
		$owner_username = get_entity($this->owner_guid)->username;
		return elgg_get_site_url() . "lets/transfer/$owner_username/$this->container_guid/";
	}
}
