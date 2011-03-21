<?php

/**
 * Explodes arrays notated as CSV, optional glue. 
 * Data-only assist; does not render content
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_ExplodeViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Explode a CSV string to an array. Useful in loops for example:
	 * <f:for each="{ws:explode(csv: '1,2,3)}" as="item"></f:for>
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