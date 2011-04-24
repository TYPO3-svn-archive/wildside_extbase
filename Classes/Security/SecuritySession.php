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
 * Contains configuration of one instance of an imposed security measure.
 * Instances are constructed and registered with the AbuseManager singleton
 * 
 * @author Claus Due, Wildside A/S
 */

class Tx_WildsideExtbase_Security_SecuritySession {
	
	/**
	 * @var string
	 */
	protected $id;
	
	/**
	 * @var int
	 */
	protected $tolerance = 0;
	
	/**
	 * @var int
	 */
	protected $gracePeriod = 300;
	
	/**
	 * @var int
	 */
	protected $abusePage = -1;
	
	/**
	 * @var boolean
	 */
	protected $quarantine = FALSE;
	
	/**
	 * @var boolean
	 */
	protected $quarantined = FALSE;
	
	/**
	 * @var boolean
	 */
	protected $quarantineIpAddress = FALSE;
	
	/**
	 * @var boolean
	 */
	protected $quarantineSession = FALSE;
	
	/**
	 * @var int
	 */
	protected $quarantinePage = -1;
	
	/**
	 * @var int
	 */
	protected $quarantineDuration = 86400;
	
	/**
	 * @var boolean
	 */
	protected $blackHole = FALSE;
	
	/**
	 * @var boolean
	 */
	protected $syslog = TRUE;
	
	/**
	 * @var array
	 */
	private $_abuseLog = array();
	
	
	public function __construct($id=NULL) {
		
	}
	
	
	
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setTolerance($tolerance) {
		$this->tolerance = $tolerance;
	}
	
	public function getTolerance() {
		return $this->tolerance;
	}
	
	public function setGracePeriod($gracePeriod) {
		$this->gracePeriod = $gracePeriod;
	}
	
	public function getGracePeriod() {
		return $this->gracePeriod;
	}
	
	public function setAbusePage($abusePage) {
		$this->abusePage = $abusePage;
	}
	
	public function getAbusePage() {
		return $this->abusePage;
	}
	
	public function setQuarantine($quarantine) {
		$this->quarantine = $quarantine;
	}
	
	public function getQuarantine() {
		return $this->quarantine;
	}
	
	public function setQuarantined($quarantine) {
		$this->quarantine = $quarantine;
	}
	
	public function getQuarantined() {
		return $this->quarantine;
	}
	
	public function setQuarantineIpAddress($quarantineIpAddress) {
		$this->quarantineIpAddress = $quarantineIpAddress;
	}
	
	public function getQuarantineIpAddress() {
		return $this->quarantineIpAddress;
	}
	
	public function setQuarantinePage($quarantinePage) {
		$this->quarantinePage = $quarantinePage;
	}
	
	public function getQuarantinePage() {
		return $this->quarantinePage;
	}
	
	public function setQuarantineDuration($quarantineDuration) {
		$this->quarantineDuration = $quarantineDuration;
	}
	
	public function getQuarantineDuration() {
		return $this->quarantineDuration;
	}
	
	public function setBlackHole($blackHole) {
		$this->blackHole = $blackHole;
	}
	
	public function getBlackHole() {
		return $this->blackHole;
	}
	
	public function setSyslog($syslog) {
		$this->syslog = $syslog;
	}
	
	public function getSyslog() {
		return $this->syslog;
	}
	
	public function getAbuseCount($abuseType=NULL) {
		if ($abuseType === NULL) {
			$abuseType = 'Tx_WildsideExtbase_Security_SecuritySession::abuseType';
		}
		return intval($this->_abuseLog[$abuseType]);
	}	
	
	/**
	 * Checks if the current session is tainted by abuse
	 * 
	 * @api
	 * @param string $abuseType The type of abuse which occurred. If specified, a local-to-type abuse counter is checked; otherwise the global counter is checked
	 * @return boolean
	 */
	public function isAbuser($abuseType=NULL) {
		return FALSE;
	}
	
	public function registerAbuse($abuseType=NULL) {
		if ($abuseType === NULL) {
			$abuseType = 'Tx_WildsideExtbase_Security_SecuritySession::abuseType';
		}
		$this->_abuseLog[$abuseType]++;
	}
	
	/**
	 * Check if the session is quarantined
	 * 
	 * @api
	 * @return booelan
	 */
	public function isQuarantined() {
		return FALSE;
	}
	
	/**
	 * No, this does not detect if your user has a blackened rectum.
	 * 
	 * @api
	 * @return boolean
	 */
	public function isBlackHoled() {
		return FALSE;
	}
	
	/**
	 * Place session under quarantine
	 * 
	 * @api
	 * @param int $duration If specified, quarantine is in effect for this many seconds
	 * @return void
	 */
	public function effectQuarantine($duration=-1) {
		if ($duration < 0) {
			$duration = $this->quarantineDuration;
		}
	}
	
	/**
	 * Lift quarantine on session
	 * 
	 * @api
	 * @param Tx_WildsideExtbase_Security_SecuritySession $session
	 * @return void
	 */
	public function liftQuarantine() {
			
	}
	
	
}