<?php

/**
 * Formats timestamps/dates
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_DateViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Render a select
	 * @param string $format The format of the date to be returned, PHP-date format
	 * @param float $timestamp The timestamp to be formatted
	 * @param string $date Optional string-formatted date, parsed into $timestamp
	 * @return string
	 */
	public function render($format, $timestamp=NULL, $date=NULL) {
		if (!$timestamp && $date) {
			$timestamp = strtotime($date);
		}
		$str = date($format, $timestamp);
		return $str;
	}
}
	

?>