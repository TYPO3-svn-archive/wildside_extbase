<?php

/**
 * Injector
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_CheckboxCheckedViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Returns "checked='checked'" if $value exists in $array
	 * 
	 * @param array $array
	 * @param mixed $value
	 * @param string $subKey
	 * @param boolean $returnBool
	 */
	public function render($array, $value, $subKey=NULL, $returnBool=FALSE) {
		if ($array instanceof Tx_Extbase_Persistence_ObjectStorage) {
			$haystack = $array->toArray();
			if ($subKey) {
				$method = 'get'.ucfirst($subKey);
				foreach ($haystack as $k=>$v) {
					$haystack[$k] = $v->$method();
				}
			}
		} else if ($subKey) {
			$haystack = $array[$subKey];
		} else {
			$haystack = $array;
		}
		$inArray = in_array($value, $haystack);
		if ($inArray) {
			if ($returnBool) {
				return TRUE;
			} else {
				return "checked='checked'";
			}
		} else {
			if ($returnBool) {
				return FALSE;
			} else {
				return '';
			}
		}
	}
}
	

?>