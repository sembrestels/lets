<?php
/**
 * Extended class to do easier the LETS management.
 */
class ElggLETSGroup extends ElggGroup {
	public function isLETS(){
		return $this->lets_enable == 'yes';
	}
}
