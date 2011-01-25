<?php

/**
 * Injector, JS
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_Inject_JsViewHelper extends Tx_WildsideExtbase_ViewHelpers_InjectViewHelper {
	
	/**
	 * Inject JS file in header or code.
	 * 
	 * Usage example, header file include from Resources/Public/js/:
	 * <ws:inject.js file="{f:uri.resource(path: 'js/file.js')}" />
	 * Optionally, supply a header key if you call the inject method several
	 * times, each time with a different md5() hash value (unlikely...)
	 * but still only need a single inclusion:
	 * <ws:inject.js file="{f:uri.resource(path: 'js/file.js')}" key="myUniqueKey" />
	 * - Will be accessible through $GLOBALS['additionalHeaderData][$key] as well.
	 * 
	 * Usage example, <script></script> code injected in <head>:
	 * <ws:inject.js>
	 * var myJsVariable = '{record.uid}';
	 * </ws:inject.js>
	 * Note that fluid variables and loops are all usable inside <ws.inject.js>. As
	 * with the above example a custom $key for additionalHeaderData may be provided.
	 * 
	 * Usage example, Javascript inside <body> - you NAUGHTY developer, shame on you!
	 * <ws:inject.js header="false">
	 * var myJsVariable = '{record.uid}';
	 * </ws:inject.js>
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