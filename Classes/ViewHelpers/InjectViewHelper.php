<?php

/**
 * Injector
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_InjectViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Void
	 * @return string
	 */
	public function render() {
		return '';
	}
	
	/**
	 * Injects $code in header data
	 *
	 * @param string $code
	 * @param bool $header
	 * @param string $key
	 */
	public function process($code=NULL, $header=TRUE, $key=NULL) {
		if ($header == TRUE) {
			if ($key == NULL) {
				$key = md5($code);
			}
			$GLOBALS['TSFE']->additionalHeaderData[$key] = $code;
		} else {
			return $code;
		}
	}
}
	

?>