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
 * DEPRECATED - but will stay for a good great while - replaced by ScriptViewHelper
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 * @deprecated
 */
class Tx_WildsideExtbase_ViewHelpers_Inject_JsViewHelper extends Tx_WildsideExtbase_ViewHelpers_ScriptViewHelper {
	
	/**
	 * DEPRECATED - $file parameter has been changed to $src in ScriptViewHelper
	 * 
	 * @param string $js
	 * @param mixed $file String filename or array of filenames
	 * @param bool $cache If true, file(s) is cached
	 * @param bool $concat If true, files are concatenated (makes sense if $file is array)
	 * @param bool $compress If true, files are compressed using JSPacker
	 * @param string $key
	 */
	public function render($js=NULL, $file=NULL, $cache=FALSE, $concat=FALSE, $compress=FALSE) {
		if ($file) {
			$this->includeFile($file);
		} else {
			return '<!-- inline script injection is deprecated in this ViewHelper - use <ws:script>...</ws:script> -->';
		}
	}
	
}
	

?>