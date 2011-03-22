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
 * Renders title (or any other field) of the first available child inside ObjectStorage
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_FirstChildViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Render name of first child inside an ObjectStorage
	 * @param Tx_Extbase_Persistence_ObjectStorage $storage
	 * @param string $field If specified, renders the provided field. If null, field "name" is rendered 
	 */
	public function render(Tx_Extbase_Persistence_ObjectStorage $storage=NULL, $field=NULL) {
		if ($storage !== NULL && $storage->count() > 0) {
			if ($field) {
				$object = $storage->current();
				$func = 'get'.ucfirst($field);
				return $object->$func();
			} else {
				return $storage->current()->getName();
			}
		} else {
			return '<!-- empty ObjectStorage instance -->';
		}
	}
}
	

?>