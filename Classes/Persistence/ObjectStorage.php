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
 * ObjectStorage - adds a few smart features to the default ObjectStorage in 
 * Extbase, among other things pagination (with direct Fluid variable support), 
 * QueryObjectModel-type filtering (100% emulates the existing Repository-Query
 * way of filtering, run createQuery() on an ObjectStorage, apply constraints and 
 * $filteredObjectStorage = $queryFromObjectStorage->execute();
 * 
 * ALL of Extbase's QueryConstraint applications are supported and function just 
 * like they would on an SQL query.
 * 
 * Chained usage is possible, short example:
 * 
 * $filtered = $wsObjectStorage->createQuery()->limit(10)->offset(100)->execute();
 * 
 * Proxy methods have been added so you can do some things from Fluid if your 
 * DomainObjects defines that it wants Tx_WildsideExtbase_Persistence_Objecstorage
 * instead of Tx_Extbase_Persistence_ObjectStorage. Indicate member types the same way
 * you would ObjectStorage: Tx_WildsideExtbase_Persistence_Objecstorage<Tx_MyExt_Domain_Model_MyDomObj>
 * 
 * A note, though: anything but page and offset is a bit slow to use in Fluid templates
 * and is most definitely best suited for use in cachable plugins.
 * 
 * The short var {do.mn} stands for {domainObject.manyRelationProperty} which
 * is a property of a DomainObject which returns a Tx_WildsideExtbase_Persistence_ObjectStorage.
 * 
 * {do.mn.page.5} // becomes a new, paginated ObjectStorage
 * {do.mn.offset.5} // use in loop argument to start from offset 5
 * {do.mn.limit.100} // use in loop argument to limit the number of loops
 * {do.mn.sort.name} // obvious, for loops (assumes ASC, "name" is property of members)
 * {do.mn.sort.name.DESC} // also obvious. ASC is default
 * 
 * Detailed example - wrapping output, for example for jQuery show/hide pages:
 * 
 * <f:for each="{do.mn.pages}" as="page" iteration="iteration">
 *     <div id="page{iteration.iteration}">
 *     <h4>Page {iteration.iteration}</h4>
 *     <f:for each="{page}" as="object">
 *         // rendering of each object
 *     </f:for>
 *     </div>
 * </f:for>
 * 
 * Note that this has a default itemsPerPage of 25. If you need a different value you
 * have three options: a) to always hard-limit, in which case use your DomainObject's 
 * setter method and run setItemsPerPage(50) before setting the internal property. Or 
 * b) getting the ObjectStorage, performing actions and the using the DomainObject's
 * setter method to refresh the value and finally c) $domainObject->getMultiRelation()->paginate($num);
 * to store the selected $num as itemsPerPage when this particular instance is referenced,
 * which it is every time the Domain Object property is accessed in Fluid.
 * 
 * Additional note on combining with Repository output:
 * 
 * If your Repository injects Tx_WildsideExtbase_Object_QueryManager and 
 * simply does this in a find***** method:
 * 
 * $query = $this->createQuery();
 * $queryResult = $query->execute();
 * return $this->queryManager->promote($queryResult);
 * 
 * ... then instead of a QueryResult instance, an Tx_WildsideExtbase_Persistence_ObjectStorage
 * fullf of objects is returned. Of course you can do this in your controller too but it makes 
 * a bit more sense in a Repository. Afterwards, you $this->view->assign('items', $outputItems);
 * and get support in your Fluid template for {items.page.5} for example.
 * 
 * The explanation is of course that Repositories' find*** usually return QueryResult 
 * which does not support the same features this class does. Running QueryManager's 
 * promote($queryResult) turns it into an objectstorage - and further allows you to detach,
 * attach etc. on multiresults from your repositories.
 * 
 * Finally, overloaded methods exists for "findBy" and "findOneBy", allowing you to treat 
 * your ObjectStorage as if it were a Repository. One result is returned as the proper type,
 * multiple results as new Tx_WildsideExtbase_Persistence_ObjectStorage, You're welcome :)
 * 
 * As if that was not enough, direct returns are also supported, allowing this in Fluid
 * (assuming your DomainObject has boolean property "active" with getter and setter):
 * 
 * {do.mn.findByActive.1} // returns objects with boolean value TRUE in "active" property
 * 
 * Go nuts. 
 * 
 * {do.mn.findByActive.1.findByCategory.math.order.lastTeachingPeriod.DESC.limit.5} - to
 * get only DomainObjects with "active" = TRUE and "category" = 'math', order descending by last 
 * teaching period and finally limit to only five results... Phew. 
 * 
 * Only limitation is that only exact matching in the "findBy" and "findOneBy" methods is allowed and
 * naturally, only whole strings and numbers should be used as to not confuse Fluid's syntax 
 * detection. Zero and One works for boolean values and integers, all others considered string-match.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_WildsideExtbase_Persistence_ObjectStorage extends Tx_Extbase_Persistence_ObjectStorage {
	
	/**
	 * @var Tx_WildsideExtbase_Object_QueryManager
	 */
	protected $queryManager;
	
	/**
	 * @var int
	 */
	protected $perPage = 25;
	
	/**
	 * @param Tx_WildsideExtbase_Object_QueryManager $queryManager
	 */
	public function injectQueryManager(Tx_WildsideExtbase_Object_QueryManager $queryManager) {
		$this->queryManager = $queryManager;
	}
	
	/**
	 * Paginage this ObjectStorage. Returns an array of O
	 * @param int $itemsPerPage
	 */
	public function paginate($itemsPerPage=-1) {
		if ($itemsPerPage > 0) {
			$this->setItemsPerPage($itemsPerPage);
		}
		return $this->getPages();
	}
	
	/**
	 * Sets the number of items displayed per page
	 * 
	 * @param unknown_type $perPage
	 * @api
	 */
	public function setItemsPerPage($perPage) {
		$this->itemsPerPage = $perPage;
	}
	
	/**
	 * Gets the number of items displayed per page
	 * 
	 * @return int
	 * @api 
	 */
	public function getItemsPerPage() {
		return $this->itemsPerPage;
	}
	
	/**
	 * Returns an array of "page" ObjectStorage instances, for chaining 
	 * in Fluid as {domainObject.manyRelation.page.5} for example. Depends on
	 * paginate() being run first in order to know how many items per page
	 * 
	 * @return array
	 * @api
	 */
	public function getPages() {
		$pages = array();
		$index = 0;
		$pageNumber = 0;
		foreach ($this as $item) {
			if (($index%$this->itemsPerPage === 0) || $index === 0) {
				$pageNumber++;
				$pages[$pageNumber] = $this->objectManager->get('Tx_WildsideExtbase_Persistence_ObjectStorage');
			}
			$pages[$pageNumber]->attach($item);
			$index++;
		}
		return $pages;
	}
	
	/**
	 * Creates a query for searching through members of this ObjectStorage.
	 * Proxy for QueryManager::createQuery with $original = $this as parameter
	 * 
	 * @return Tx_WildsideExtbase_Object_Query
	 * @api
	 */
	public function createQuery() {
		return $this->queryManager->createQuery($this);
	}
	
	/**
	 * Overloaded property getter. Makes a few predefined dynamic variables available (in Fluid, too),
	 * for example as {do.mn.limit.5}. See Tx_WildsideExtbase_Object_AbstractOverloader.
	 * 
	 * @param string $name
	 * @return Tx_WildsideExtbase_Object_AbstractOverloader Subclass of AbstractOverloader, implementing ArrayAccess
	 */
	public function __get($name) {
		switch ($name) {
			case 'limit': $overloader = 'Tx_WildsideExtbase_Object_Limiter'; break;
			case 'offset': $overloader = 'Tx_WildsideExtbase_Object_Offsetter'; break;
			case 'page': $overloader = 'Tx_WildsideExtbase_Object_Paginater'; break;
			default: $overloader = NULL;
		}
		if ($overloader) {
			return $this->objectManager->get($overloader)->setOriginal($this);
		}
		return NULL;
	}
	
	/**
	 * Overloaded method caller. Handles findBy**** and others
	 * @param string $func
	 * @param array $arguments
	 */
	public function __call($func, $arguments) {
		
	}
	
}

?>