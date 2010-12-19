<?php

/**
 * Renders title of the first available child object
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_FirstChildViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Render name of first child
	 * @param Tx_Extbase_Persistence_ObjectStorage $storage
	 */
	public function render(Tx_Extbase_Persistence_ObjectStorage $storage=NULL) {
		if ($storage !== NULL && $storage->count() > 0) {
			return $storage->current()->getName();
		} else {
			return 'Not set';
		}
	}
}
	

?>