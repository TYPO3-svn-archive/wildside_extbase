<?php

/**
 * Helps with formatting of numbers
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_NumberViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Render a select
	 * @param float $number The number to be formatted
	 * @param int $decimals The number of decimals to output
	 * @param string $dsep The character used as decimal separator
	 * @param string $tsep The character used as thousands separator
	 * @param string $unit The unit to use as suffix for the rendered number
	 * @return string
	 */
	public function render($number, $decimals=NULL, $dsep=NULL, $tsep=NULL, $unit=NULL) {
		$str = number_format($number, $decimals, $dsep, $tsep);
		if ($unit) {
			$str .= $unit;
		}
		return $str;
	}
}
	

?>