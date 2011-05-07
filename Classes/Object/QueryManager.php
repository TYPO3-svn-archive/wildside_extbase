<?php 
/***************************************************************
*  Copyright notice
*
*  (c) 2010 
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
 * Allows running storage-type Query requests on 
 * 
 * @author Claus Due, Wildside A/S
 */
class Tx_WildsideExtbase_Object_QueryManager implements t3lib_Singleton {
	
	/**
	 * @var Tx_Extbase_Object_Manager
	 */
	protected $objectManager;
	
	/**
	 * @param Tx_Extbase_Object_Manager $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_Manager $objectManager) {
		$this->objectManager = $objectManager;
	}
	
	/**
	 * Creates a query for searching through members of this ObjectStorage
	 * 
	 * @param mixed $original Original value - object, array, ObjectStorage or QueryResult
	 * @return Tx_WildsideExtbase_Object_Query
	 * @api
	 */
	public function createQuery($original) {
		$query = $this->objectManager->get('Tx_WildsideExtbase_Object_Query');
		$query->setOriginal($original);
		return $query;
	}
	
	/**
	 * Promotes a QueryResult to an Tx_WildsideExtbase_Persistence_ObjectStorage
	 * 
	 * @param Tx_Extbase_Persistence_QueryResult $queryResult
	 * @return Tx_WildsideExtbase_Persistence_ObjectStorage
	 */
	public function promote(Tx_Extbase_Persistence_QueryResult $queryResult) {
		$promoted = $this->objectManager->get('Tx_WildsideExtbase_Persistence_ObjectStorage');
		foreach ($queryResult as $item) {
			$promoted->attach($item);
		}
		return $promoted;
	}
	
}

?>