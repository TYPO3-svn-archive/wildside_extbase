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

class Tx_WildsideExtbase_Utility_RecursionHandler implements t3lib_Singleton {
	
	private $_exceptionMessage = 'Recursion problem occurred';
	private $_level = 0;
	private $_maxLevel = 16;
	private $_maxEncounters = 1;
	private $_encountered = array();
	private $_autoReset = FALSE;
	
	public function setExceptionMessage($msg) {
		$this->_exceptionMessage = $msg;
	}
	
	public function setAutoReset($reset) {
		$this->_autoReset = $reset;
	}
	
	public function setMaxEncounters($max) {
		$this->_maxEncounters = $max;
	}
	
	public function getMaxEncounters() {
		return $this->_maxEncounters;
	}
	
	public function setMaxLevel($level) {
		$this->_maxLevel = $level;
	}
	
	public function getMaxLevel() {
		return $this->_maxLevel;
	}
	
	public function getLevel() {
		return $this->_level;
	}
	
	public function getLastEncounter() {
		return array_pop($this->_encountered);
	}
	
	public function in() {
		$this->_level++;
	}
	
	public function out() {
		$this->_level--;
	}
	
	public function encounter($data) {
		array_push($this->_encountered, $data);
		$this->check();
	}
	
	public function check($exitMsg='<no message>') {
		$level = $this->getLevel();
		$maxEnc = $this->getMaxEncounters();
		$message = $this->getExceptionMessage();
		if ($this->failsOnLevel()) {
			$msg = "{$message} at level {$level} with message: {$exitMsg}";
			throw new Exception($msg);
		}
		if ($this->failsOnMaxEncounters()) {
			$msg = "{$message} at encounter {$maxEnc} of {$maxEnc} allowed with message: {$exitMsg}";
			$this->throwException($msg);
		}
		return TRUE;
	}
	
	public function reset() {
		$this->_level = 0;
		$this->_encountered = array();
	}
	
	private function throwException($message) {
		if ($this->_autoReset === TRUE) {
			$this->reset();
		}
		throw new Exception($message);
	}
	
	private function failsOnLevel() {
		$level = $this->getLevel();
		$max = $this->getMaxLevel();
		return (bool) ($level >= $max);
	}
	
	private function failsOnMaxEncounters() {
		$lastEncounter = $this->getLastEncounter();
		$occurrences = $this->countEncounters($lastEncounter);
		$max = $this->getMaxEncounters();
		return (bool) ($occurrences > $max);
	}
	
	private function countEncounters($encounter) {
		$num = 0;
		foreach ($this->_encountered as $encountered) {
			if ($encountered === $encounter) {
				$num++;
			}
		}
		return (int) $num;
	}
	
}

?>