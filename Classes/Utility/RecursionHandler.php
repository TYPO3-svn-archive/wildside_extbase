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
	private $_encountered = array();
	
	
	public function setExceptionMessage($msg) {
		$this->_exceptionMessage = $msg;
	}
	
	public function setMaxLevel($level) {
		$this->_maxLevel = $level;
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
		if ($this->_level >= $this->_maxLevel) {
			throw new Exception($this->_exceptionMessage . ' at level ' . $this->_level . ' with message: ' . $exitMsg);
		}
		if (count($this->_encountered) > 0 && count(array_unique($this->_encountered)) != count($this->_encountered)) {
			throw new Exception($this->_exceptionMessage . ' at level ' . $this->_level . ' with message: ' . $exitMsg);
		}
	}
	
	public function reset() {
		$this->_level = 0;
		$this->_encountered = array();
	}
	
	
	
}

?>