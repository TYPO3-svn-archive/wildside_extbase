<?php 
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Claus Due <claus@wildside.dk>, Wildside A/S
*  			
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

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
		$this->includes();
		if (strlen($value) == 0) {
			$value = 'Click to enter text';
		}
		$field = "<{$tag} class='aloha {$class}'>{$value}</{$tag}>";
		if ($ruleSelector && $rule) {
			$field .= $this->getRule($ruleSelector, $rule);
		}
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
		$init = <<< SCRIPT
GENTICS.Aloha.settings = {
	//logLevels: {'error': true, 'warn': true, 'info': false, 'debug': false},
	logLevels : false,
	errorhandling : false,
	ribbon: false,	
	"i18n": { "current": "en" },
	"plugins": {
		"com.gentics.aloha.plugins.Format": {
			config : [ 'b', 'i','u','del','sub','sup', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'pre'],
			editables : {
				'.noFormatting' : []
			}
		},
	 	"com.gentics.aloha.plugins.List": {
	 		config : [ 'ol', 'ul' ],
			editables : {
				'.noFormatting' : []
			}
		},
		"com.gentics.aloha.plugins.Link": {
			config : [ 'a' ],
			editables : {
				'.noFormatting' : []
			}
			/*,
			onHrefChange: function( obj, href, item ) {
				// Make sure that links are not allowed inside Aloha-objects instantiated
				// on headers. Sadly, the above configuration is not enough to keep the 
				// link button hidden at all times.
				// ... and this code doesn't work. Sigh.
				var p = jQuery(obj).parents('.GENTICS_editable:first').filter(':header');
				if (p.length) obj.remove();
			}
			*/
		},
		"com.gentics.aloha.plugins.Table": {}
	}
};
// Subscribe to the edit-finish event on all existing (and future) Aloha-instances.
GENTICS.Aloha.EventRegistry.subscribe(GENTICS.Aloha, "editableActivated", function(event, eventProperties) {
	jQuery(eventProperties.editable.obj).data("field").beginEdit();
});

GENTICS.Aloha.EventRegistry.subscribe(GENTICS.Aloha, "editableDeactivated", function(event, eventProperties) {
	if (eventProperties.editable.isModified()) {
		jQuery(eventProperties.editable.obj).data("field").endEdit();
		eventProperties.editable.setUnmodified();
	};
});
SCRIPT;
		$includer = t3lib_div::makeInstance('Tx_WildsideExtbase_ViewHelpers_Inject_JsViewHelper');
		foreach ($files as $file) {
			$includer->render(NULL, $jsBasePath.$file);
		}
		$includer->render($init);
		return TRUE;
	}
	
}


?>