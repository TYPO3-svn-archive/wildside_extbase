<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Claus Due <claus@wildside.dk>, Wildside A/S
*  
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 3 of the License, or
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

class Tx_WildsideExtbase_Utility_DataSourceParser implements t3lib_Singleton {

	/**
	 * @var Tx_WildsideExtbase_Utility_JSON
	 */
	protected $jsonHandler;
	
	/**
	 * @param Tx_WildsideExtbase_Utility_JSON $jsonHandler
	 */
	protected function injectJSONHandler(Tx_WildsideExtbase_Utility_JSON $jsonHandler) {
		$this->jsonHandler = $jsonHandler;
	}
	
	/**
	 * @param array $sources
	 * @return array
	 */
	public function parseDataSources(array $sources) {
		foreach ($sources as $k=>$v) {
			$sources[$k] = $this->parseDataSource($v);
		}
		return $sources;
	}
	
	/**
	 * @param Tx_WildsideExtbase_Domain_Model_DataSource $source
	 * @return Tx_WildsideExtbase_Domain_Model_DataSource
	 */
	public function parseDataSource(Tx_WildsideExtbase_Domain_Model_DataSource $source) {
		$data = $this->gatherData($source);
		$source->setData($data);
		return $source;
	}
	
	/**
	 * @param Tx_WildsideExtbase_Domain_Model_DataSource $source
	 * @return array
	 */
	public function gatherData(Tx_WildsideExtbase_Domain_Model_DataSource $source) {
		$probeUrl = $source->getUrl();
		$probeQuery = $source->getQuery();
		if ($probeQuery) {
			$data = $this->fetchDataByQuery($probeQuery);
		} else if ($probeUrl) {
			$probeUrlMethod = $source->getUrlMethod();
			$data = $this->fetchDataByUrl($probeUrl, $probeUrlMethod);
		} else {
			throw new Exception('Could not fetch data from DataSource - no usable source defined');
		}
		
		return (array) $data;
	}
	
	/**
	 * Fetch data by $query
	 * @param string $query
	 * @return array
	 */
	private function fetchDataByQuery($query) {
		$array = array();
		$result = $GLOBALS['TYPO3_DB']->sql_query($query);
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)) {
			array_push($array, $row);
		}
		return (array) $array;
	}
	
	/**
	 * Fetch data by $url and $method
	 * @param string $url
	 * @param string $method
	 */
	private function fetchDataByUrl($url, $method) {
		
	}
	
}