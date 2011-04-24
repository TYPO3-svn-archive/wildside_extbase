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

class Tx_WildsideExtbase_Security_AbuseManager implements t3lib_Singleton {
	
	/**
	 * Start a new SecuritySession and register for monitoring. Chaining available on return value
	 * 
	 * @api
	 * @param string $id Mandatory ID for this particular session (not browser session; security session - multiple security sessions may be registed for each browser session)
	 * @return Tx_WildsideExtbase_Security_SecuritySession
	 */
	public function startSession($id) {
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$session = $objectManager->get('Tx_WildsideExtbase_Security_SecuritySession');
		$session->setId($id);
		return $this->registerSecuritySession($session);
	}
	
	/**
	 * Registers a SecuritySession for monitoring
	 * 
	 * @api
	 * @param Tx_WildsideExtbase_Security_SecuritySession $session
	 * @return void
	 */
	public function registerSecuritySession(Tx_WildsideExtbase_Security_SecuritySession $session) {
		return $session;
	}
	
	/**
	 * Unregister this SecuritySession
	 * 
	 * @api
	 * @param Tx_WildsideExtbase_Security_SecuritySession $session
	 * @return void
	 */
	public function unregisterSecuritySession(Tx_WildsideExtbase_Security_SecuritySession $session=NULL) {
		
	}
	
	/**
	 * Get an identified (or session registered) SecuritySession
	 * 
	 * @api
	 * @param string $id
	 * @return Tx_WildsideExtbase_Security_SecuritySession
	 */
	public function getSecuritySession($id=NULL) {
		
		return $session;
	}
	
	/**
	 * Get all SecuritySessions for the current browser session
	 * 
	 * @api
	 * @return array
	 */
	public function getAllSecuritySessions() {
		$sessions = array();
		return (array) $sessions;
	}
	
	/**
	 * Fetch SecuritySession from argument - autofetch if NULL
	 * 
	 * @param Tx_WildsideExtbase_Security_SecuritySession $session
	 * @return Tx_WildsideExtbase_Security_SecuritySession
	 */
	private function fetchSession(Tx_WildsideExtbase_Security_SecuritySession $session=NULL) {
		if ($session === NULL) {
			// make sure that we return the current session if one exists and no $session argument was specified
			$session = $this->getSecuritySession(NULL);
		}
		return $session;
	}
	
	
}