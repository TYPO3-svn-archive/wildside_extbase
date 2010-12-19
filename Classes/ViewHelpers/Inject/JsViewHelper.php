<?php

/**
 * Injector
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_Inject_JsViewHelper extends Tx_WildsideExtbase_ViewHelpers_InjectViewHelper {
	
	/**
	 * Inject JS file in header or code
	 * 
	 * @param string $js
	 * @param string $file
	 * @param bool $header
	 * @param string $key
	 */
	public function render($js=NULL, $file=NULL, $header=TRUE, $key=NULL) {
		if ($js === NULL) {
			$js = $this->renderChildren();
		}
		if ($file && $header) {
			$code = "<script type='text/javascript' src='{$file}'></script>";
		} else if ($js) {
			$code = "<script type='text/javascript'>\n{$js}\n</script>";
		}
		return $this->process($code, $header, $key);
	}
}
	

?>