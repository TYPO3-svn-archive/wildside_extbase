<?php

/**
 * Injector
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_SelectSelectedViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Returns "selected='selected'" if $value exists in $array
	 * 
	 * @param array $array
	 * @param mixed $value
	 * @param string $subKey
	 */
	public function render($array, $value, $subKey=NULL) {
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
			return "selected='selected'";
		}
	}
}
	

?>