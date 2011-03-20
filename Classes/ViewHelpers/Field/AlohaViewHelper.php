<?php 







class Tx_WildsideExtbase_ViewHelpers_Field_AlohaViewHelper extends Tx_WildsideExtbase_ViewHelpers_FieldViewHelper {
	
	/**
	 * Render the Field
	 * 
	 * @param string $displayType Type (WS JS domain style) of Field 
	 * @param string $name Name property of the Field
	 * @param string $value Value property of the Field
	 * @param string $class Class property of the Field
	 * @param string $type Type (input, hidden, radio, checkbox) of the <input> field
	 * @param string $sanitizer WS JS Domain style reference to validator method
	 * @param string $tag Tagname to use for rendered container
	 * @param string $ruleSelector CSS selector for rule. If specified, needs rule parameter too
	 * @param array $rule Array of rules for elements matching ruleSelector CSS selector parameter
	 */
	public function render(
			$displayType='dk.wildside.display.field.Aloha', 
			$name=NULL, 
			$value=NULL, 
			$class=NULL, 
			$type='input', 
			$sanitizer=NULL, 
			$tag='p',
			$ruleSelector=NULL,
			$rule=NULL) {
		// NOTE: why is the default text forced? Zero-length editable fields are 
		// not really editable... You could argue that with proper styling this 
		// is not an issue - but is using value=" " in your template a problem if 
		// you consider that the AlohaViewHelper has an auto-trim Sanitizer? ;)
		if (strlen($value) == 0) {
			$value = 'Click to enter text';
		}
		$field = "<{$tag} class='aloha {$class}'>{$value}</{$tag}>";
		if ($ruleSelector && $rule) {
			$field .= $this->getRule($ruleSelector, $rule);
		}
		$this->includes();
		return parent::render($field, $displayType, $name, $value, NULL, $sanitizer);
	}
	
	private function getRule($selector, array $rule=NULL) {
		$json = json_encode($rule);
		if ($GLOBALS['wildsideExtbaseAlohaRules'][$selector] == $json) {
			return '';
		}
		$GLOBALS['wildsideExtbaseAlohaRules'][$selector] = $json;
		return "<div class='wildside-extbase-aloha-rule' title='{$selector}'>{$json}</div>";
	}
	
	private function includes() {
		$jsBasePath = t3lib_extMgm::siteRelPath('wildside_extbase') . 'Resources/Public/Javascript/';
		$files = array(
			'com/gentics/aloha/aloha.js',
			'com/gentics/aloha/plugins/com.gentics.aloha.plugins.Format/plugin.js',
			'com/gentics/aloha/plugins/com.gentics.aloha.plugins.Table/plugin.js',
			'com/gentics/aloha/plugins/com.gentics.aloha.plugins.List/plugin.js',
			'com/gentics/aloha/plugins/com.gentics.aloha.plugins.Link/plugin.js',
			'com/gentics/aloha/plugins/com.gentics.aloha.plugins.Link/LinkList.js',
			'com/gentics/aloha/plugins/com.gentics.aloha.plugins.Paste/plugin.js',
			'com/gentics/aloha/plugins/com.gentics.aloha.plugins.Paste/wordpastehandler.js'
		);
		$includer = t3lib_div::makeInstance('Tx_WildsideExtbase_ViewHelpers_Inject_JsViewHelper');
		foreach ($files as $file) {
			$includer->render(NULL, $jsBasePath.$file);
		}
		return TRUE;
	}
	
}


?>