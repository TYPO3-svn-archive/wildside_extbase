<?php 







class Tx_WildsideExtbase_ViewHelpers_AlohaViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Includes Aloha resource files and places initialization code block in page header
	 * 
	 * @param string $init
	 * @return string
	 */
	public function render($init=NULL) {
		$this->includes();
		if ($init == NULL) {
			$init = $this->renderChildren();
		}
		return $content;
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