<?php
/**
 * Extended class to do easier the LETS management.
 */
class ElggLETSAccount extends ElggObject {
	
	public function __construct(int $owner_guid, int $container_guid = NULL){
		
		$account_guid = self::getAccountGUID($owner_guid, $container_guid);
		$owner = get_entity($owner_guid);
		
		if($account_guid){
			parent::__construct($account_guid);
			
		} elseif($owner && $owner->getType() == 'object' && $owner->getSubtype() == 'lets-account') {
			parent::__construct($owner->guid);
		
		} else {
			parent::__construct();
			$this->set('owner_guid', $owner_guid);
			$this->set('container_guid', $container_guid);
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
		} else {
			return false;
		}
	}
	
}
