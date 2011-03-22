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
 * Injector base class
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
abstract class Tx_WildsideExtbase_ViewHelpers_InjectViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Void
	 * @return string
	 */
	public function render() {
		return '';
	}
	
	/**
	 * Injects $code in header data
	 *
	 * @param string $code
	 * @param bool $header
	 * @param string $key
	 */
	public function process($code=NULL, $header=TRUE, $key=NULL) {
		if ($header == TRUE) {
			if ($key == NULL) {
				$key = md5($code);
			}
			$GLOBALS['TSFE']->additionalHeaderData[$key] = $code;
		} else {
			return $code;
		}
	}
}
	

?>