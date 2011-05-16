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

/**
 * Injector, JS
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_ScriptViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Inject JS file in the header code.
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
	 * @param mixed $src String filename or array of filenames
	 * @param bool $cache If true, file(s) is cached
	 * @param bool $concat If true, files are concatenated (makes sense if $file is array)
	 * @param bool $compress If true, files are compressed using JSPacker
	 * @param string $key
	 * @return string
	 */
	public function render($src=NULL, $cache=FALSE, $concat=FALSE, $compress=FALSE) {
		if ($src === NULL) {
			$js = $this->renderChildren();
			$this->includeHeader($js, 'js');
		} else if (is_array($src)) {
			$this->includeFiles($src, $cache, $compress);
		} else {
			$this->includeFile($src, $cache, $compress);
		}
		return NULL;
	}
}
	

?>