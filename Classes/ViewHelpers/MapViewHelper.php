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


class Tx_WildsideExtbase_ViewHelpers_MapViewHelper extends Tx_WildsideExtbase_ViewHelpers_InjectViewHelper {
	
	/**
	 * @param array $addresses
	 * @param float $lat
	 * @param float $lng
	 * @param string $api
	 */
	public function render(array $addresses=array(), $lat=NULL, $lng=NULL, $api=NULL) {
		if ($api === NULL) {
			$api = "http://maps.google.com/maps/api/js?v=3.2&sensor=true_or_false";
		}
		$this->includeFile($api);
		$init = <<< INIT

INIT;
		$code = $this->wrap($init);
		$this->process($code, Tx_WildsideExtbase_ViewHelpers_InjectViewHelper::TYPE_JAVASCRIPT);
		return 'MAP';
	}
	
}
?>