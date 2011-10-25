<?php
/**
 * Extended class to do easier the LETS management.
 */
class ElggLETSUser extends ElggUser {

	public function acceptsCurrency($currency){
		$group = new ElggGroup($currency);
		return $group->lets_enable == 'yes'
			&& $group->isMember($guid);
			//&& check_entity_relaitonship($guid, 'accept_currency', $group->guid);
	}
}
