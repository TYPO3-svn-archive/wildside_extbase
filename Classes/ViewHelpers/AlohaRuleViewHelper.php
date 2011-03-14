<?php

/**
 * Helps create a wrapper for an Item
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_AlohaRuleViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Insert a definition of an aloha CSS-selector based toolbar configuration
	 * @param string $selector
	 * @param array $rule
	 * @return string
	 */
	public function render($selector, array $rule=NULL) {
		$json = json_encode($rule);
		if ($GLOBALS['wildsideExtbaseAlohaRules'][$selector] == $json) {
			return '';
		}
		$GLOBALS['wildsideExtbaseAlohaRules'][$selector] = $json;
		return "<div class='wildside-extbase-aloha-rule' title='{$selector}'>{$json}</div>";
	}
}

?>