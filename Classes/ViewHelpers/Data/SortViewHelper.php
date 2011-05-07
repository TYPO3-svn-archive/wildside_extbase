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


class Tx_WildsideExtbase_ViewHelpers_Data_SortViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractTagBasedViewHelper {
	
	public function initializeArguments() {
		$this->registerArgument('sortBy', 'string', 'Which property/field to sort by - leave out for numeric sorting based on indexes(keys)', FALSE, FALSE);
		$this->registerArgument('order', 'string', 'ASC or DESC', FALSE, 'ASC');
		$this->registerArgument('reference', 'boolean', 'TRUE to change variable and return it, FALSE to only return it', FALSE, TRUE);
	}
	
	/**
	 * "Render" method - sorts a target list-type target. Either $array or $objectStorage must be specified. If both are,
	 * ObjectStorage takes precedence.
	 * 
	 * @param array $array Optional; use to sort an array
	 * @param Tx_Extbase_Persistence_ObjectStorage $objectStorage Optional; use to sort an ObjectStorage
	 * @return mixed
	 */
	public function render(&$array=NULL, Tx_Extbase_Persistence_ObjectStorage &$objectStorage=NULL) {
		if ($objectStorage) {
			if ($reference) {
				$workObjectStorage =& $workObjectStorage;
			} else {
				$workObjectStorage = $this->objectManager->get('Tx_Extbase_Persistence_ObjectStorage');
			}
			return $this->sortObjectStorage($workObjectStorage);
		} else if ($array) {
			if (!$reference) {
				$workArray =& $array;
			} else {
				$workArray = array_combine(array_keys($array), array_values($array));
				
			}
			return $this->sortArray($workArray);
		} else {
			throw new Exception('Nothing to sort, SortViewHelper has no purpose in life, performing LATE term self-abortion');
		}
	}
	
	protected function sortArray(&$array) {
		
		return $array;
	}
	
	protected function sortObjectStorage(&$storage) {
		
		return $storage;
	}
}

?>