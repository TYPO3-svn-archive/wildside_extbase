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

class Tx_WildsideExtbase_ViewHelpers_DataSourceViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	/**
	 * 
	 * @param string $name
	 * @param mixed $source
	 */
	public function render($name=NULL, $source) {
		$repository = $this->objectManager->get('Tx_WildsideExtbase_Domain_Repository_DataSourceRepository');
		$parser = $this->objectManager->get('Tx_WildsideExtbase_Utility_DataSourceParser');
		if (is_array($source)) {
			$sources = $respository->findByUids($source);
		} else {
			$sources = $repository->searchByName($source)->toArray();
			if (count($source) == 0) {
				// see íf $source is an uid, if it is then load - and subject to parsing as usual
				$testUid = intval($source);
				if ($testUid > 0) {
					$sources = $repository->findOneByUid($source);
				}
			}
		}
		
		$sources = $parser->parseSources($sources); // property data is filled in all sources
		
		if (count($sources) == 1) {
			$source = array_pop($sources);
			$value = $source->getData();
		} else if (count($sources) == 0) {
			return NULL;
		}
		
		if (count($value) == 1) {
			$value = array_pop($value);
			if (is_array($value) && count($value) == 1) {
				$value = array_pop($value);
			}
		}
		if ($name === NULL) {
			return $value;
		} else {
			if ($this->templateVariableContainer->exists($name)) {
				$this->templateVariableContainer->remove($name);
			}
			$this->templateVariableContainer->add($name, $value);
		}
	}
	
}

?>