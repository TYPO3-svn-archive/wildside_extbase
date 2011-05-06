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
 * Interoperability with TCA selector value definitions
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 * @deprecated
 */
class Tx_WildsideExtbase_ViewHelpers_TcaViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Translates TCA multichoice field values (int) into the key used for the value
	 * DEPRECATED - will be removed shortly
	 * 
	 * @param string $modelObject The model object's TCA key
	 * @param string $field The name of the field to get $value key from
	 * @param int $value The value for which to detect the corresponding key
	 * @return string
	 * @deprecated
	 */
	public function render($modelObject, $field, $value=NULL) {
		global $TCA;
		if ($value === NULL) {
			$value = $this->renderChildren();
		}
		$tcaItems = $TCA[$modelObject]['columns'][$field]['config']['items'];
		$key = $tcaItems[$value][0];
		return $key . " <!-- WARNING: DEPRECATED VIEWHELPER USAGE: ws:tca -->";
	}
}
	

?>