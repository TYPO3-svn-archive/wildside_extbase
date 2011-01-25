<?php

/**
 * Renders $value or children as a string with first character 'Uppercased'
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_Format_UcfirstViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Renders $value or children as a string with first character 'Uppercased'
	 * @param string $value The string to be formatted
	 * @return string
	 */
	public function render($value=NULL) {
		if ($value === NULL) {
			$value = $this->renderChildren();
		}
		$string = ucfirst($value);
		return $string;
	}
}
	

?>