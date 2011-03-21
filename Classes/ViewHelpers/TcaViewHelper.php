<?php

/**
 * Interoperability with TCA selector value definitions
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_TcaViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Translates TCA multichoice field values (int) into the key used for the value
	 * @param string $modelObject The model object's TCA key
	 * @param string $field The name of the field to get $value key from
	 * @param int $value The value for which to detect the corresponding key
	 * @return string
	 */
	public function render($modelObject, $field, $value=NULL) {
		global $TCA;
		if ($value === NULL) {
			$value = $this->renderChildren();
		}
		$tcaItems = $TCA[$modelObject]['columns'][$field]['config']['items'];
		$key = $tcaItems[$value][0];
		return $key;
	}
}
	

?>