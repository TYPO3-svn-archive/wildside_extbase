<?php

/**
 * Injector, CSS
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_Inject_CssViewHelper extends Tx_WildsideExtbase_ViewHelpers_InjectViewHelper {
	
	/**
	 * Inject CSS file in header or code. See examples in Inject/JsViewHelper.php;
	 * the pragma is identical - only the output wrapper tags are different.
	 * 
	 * @param string $file
	 * @param string $css
	 * @param bool $header
	 * @param string $key
	 */
	public function render($file=NULL, $css=NULL, $header=TRUE, $key=NULL) {
		if ($file && $header) {
			$code = "<link rel='stylesheet' type='text/css' href='{$file}' />";
		} else if ($css) {
			$code = "<style type='text/css'>{$css}</style>";
		}
		return $this->process($code, $header, $key);
	}
}
	

?>