<?php

/**
 * Formats timestamps/dates
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_Format_UcfirstViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Render a select
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