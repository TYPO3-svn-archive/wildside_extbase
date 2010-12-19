<?php

/**
 * Explodes arrays notated as CSV, optional glue
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_ExplodeViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Render a select
	 * @param string $csv The string to be exploded
	 * @param string $glue String on which to explode
	 * @return array
	 */
	public function render($csv=NULL, $glue=',') {
		if ($csv == NULL) {
			$csv = $this->renderChildren();
		}
		$arr = explode($glue, $csv);
		return $arr;
	}
}
	

?>