<?php

/**
 * Implodes array to CSV
 * Data-only assist; does not render content
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_ImplodeViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Implodes array into CSV string. Useful for example when giving 
	 * initial payload data to JS:
	 * <ws:inject.js>
	 * var payload = '<ws:implode array="{exampleArrayOfUidsOrObjectStorage}" />';
	 * </ws:inject.js>
	 * 
	 * Or when initializing values for AJAX calls into input fields:
	 * <f:form.hidden value="{ws:implode(array: exampleArrayOfUidsOrObjectStorage)}" />
	 * 
	 * If $array is an ObjectStorage, it will be traversed and its Uids 
	 * will be used for the list.
	 * 
	 * @param string $array The array to be imploded
	 * @param string $glue String glue
	 * @return array
	 */
	public function render($array, $glue=',') {
		if (is_object($array)) {
			$values = array();
			foreach ($array as $item) {
				$values[] = $item->getUid();
			}
			$array = $values;
		}
		$str = implode($glue, $array);
		return $str;
	}
}
	

?>