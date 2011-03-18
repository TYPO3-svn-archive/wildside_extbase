<?php 







class Tx_WildsideExtbase_ViewHelpers_ApiViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Includes all JS API name spaces for the domain $domain
	 * 
	 * @param string $domain The domain path of the API to load. Defaults to dk.wildside
	 * @return string
	 */
	public function render($domain='dk.wildside') {
		$this->includes($domain);
		return $this->renderChildren();
	}
	
	private function includes($namespace) {
		
		// domain minus the TLD is the extension name using dots instead of underscores
		$splitNamespace = $parts = explode('.', $namespace);
		$tld = array_shift($parts);
		$extensionName = implode('_', $parts);  
		$path = implode('/', $splitNamespace) . "/";
		if ($extensionName == 'wildside') {
			$extensionName = 'wildside_extbase';
		}
		$jsBasePath = t3lib_extMgm::siteRelPath($extensionName) . 'Resources/Public/Javascript/';
		$namespaceFile = "{$jsBasePath}{$namespace}.js";
		$contents = file_get_contents(PATH_site . $namespaceFile);
		$lines = explode("\n", $contents);
		$includer = t3lib_div::makeInstance('Tx_WildsideExtbase_ViewHelpers_Inject_JsViewHelper');
		$includer->render(NULL, $jsBasePath.$namespace.'.js');
		foreach ($lines as $file) {
			// look for coment-out plus one space - identifies a required file local to the JS namespace
			if (substr($file, 0, 3) == '// ') {
				$file = trim(str_replace('//', '', $file));
				$includer->render(NULL, $jsBasePath.$path.$file);
			}
		}
		#die();
		return TRUE;
	}
	
}






?>