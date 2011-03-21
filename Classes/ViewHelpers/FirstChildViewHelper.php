<?php

/**
 * Renders title (or any other field) of the first available child inside ObjectStorage
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_FirstChildViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Render name of first child inside an ObjectStorage
	 * @param Tx_Extbase_Persistence_ObjectStorage $storage
	 * @param string $field If specified, renders the provided field. If null, field "name" is rendered 
	 */
	public function render(Tx_Extbase_Persistence_ObjectStorage $storage=NULL, $field=NULL) {
		if ($storage !== NULL && $storage->count() > 0) {
			if ($field) {
				$object = $storage->current();
				$func = 'get'.ucfirst($field);
				return $object->$func();
			} else {
				return $storage->current()->getName();
			}
		} else {
			return '<!-- empty ObjectStorage instance -->';
		}
	}
}
	

?>