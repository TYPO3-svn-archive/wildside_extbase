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






class Tx_WildsideExtbase_ViewHelpers_ApiViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
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