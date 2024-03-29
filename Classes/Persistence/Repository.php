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
 * Repository base class
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
abstract class Tx_WildsideExtbase_Persistence_Repository extends Tx_Extbase_Persistence_Repository {


	/**
	 * Find by list of uids
	 * 
	 * @param $uids
	 * @return Tx_Extbase_Persistence_ObjectStorage
	 */
	public function findByUids($uids) {
		if (is_array($uids) == FALSE) {
			$uids = explode(',', $uids);
		}
		$query = $this->createQuery();
		$query->matching($query->in('uid', $uids));
		$results = $query->execute();
		return $results;
	}
	
	
	
}

?>