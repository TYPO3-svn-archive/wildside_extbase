<?php 







class Tx_WildsideExtbase_ViewHelpers_ApiViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Includes all JS API name spaces for the domain $domain
	 * 
	 * @param string $init
	 * @return string
	 */
	public function render($domain=NULL) {
		$this->includes($domain);
		return $this->renderChildren();
	}
	
	private function includes($namespace) {
		$path = str_replace('.', '/', $namespace) . '/';
		$pathinfo = pathinfo($namespace);
		$extension = $pathinfo['extension'];
		if ($extension == 'wildside') {
			$extension = 'wildside_extbase';
		}
		$jsBasePath = t3lib_extMgm::siteRelPath($extension) . 'Resources/Public/Javascript/';
		$namespaceFile = "{$jsBasePath}{$namespace}.js";
		$contents = file_get_contents(PATH_site . $namespaceFile);
		#echo PATH_site . $namespaceFile;
		#echo $contents;
		$lines = explode("\n", $contents);
		$includer = t3lib_div::makeInstance('Tx_WildsideExtbase_ViewHelpers_Inject_JsViewHelper');
		$includer->render(NULL, $jsBasePath.$namespace.'.js');
		foreach ($lines as $file) {
			#echo $file."<br />";
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