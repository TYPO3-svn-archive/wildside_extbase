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

class Tx_WildsideExtbase_ViewHelpers_Map_MarkerViewHelper extends Tx_WildsideExtbase_ViewHelpers_MapViewHelper {
	
	
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerTagAttribute('clickable', 'boolean', 'If true, the marker receives mouse and touch events. Default value is true.');
		$this->registerTagAttribute('cursor', 'string', 'Mouse cursor to show on hover');	
		$this->registerTagAttribute('draggable ', 'boolean ', 'If true, the marker can be dragged. Default value is false.');
		#$this->registerTagAttribute('icon', 'mixed', 'Icon filename or Object of MarkerImage options');
		$this->registerTagAttribute('flat ', 'boolean ', 'If true, the marker shadow will not be displayed.');
		$this->registerTagAttribute('raiseOnDrag ', 'boolean ', 'If false, disables raising and lowering the marker on drag. This option is true by default.');
		$this->registerTagAttribute('title ', 'string ', 'Rollover text');
		$this->registerTagAttribute('visible ', 'boolean ', 'If true, the marker is visible');
		$this->registerTagAttribute('zIndex', 'float', 'All Markers are displayed on the map in order of their zIndex, with higher values displaying in front of Markers with lower values. By default, Markers are displayed according to their latitude, with Markers of lower latitudes appearing in front of Markers at higher latitudes.');
		$this->registerTagAttribute('infobox', 'string', 'Optional infobox HTML');
		
	}
	
	/**
	 * Render a Map Marker
	 * 
	 * @param string $infoBox
	 */
	public function render($infoBox=NULL) {
		if ($infoBox === NULL) {
			$infoBox = $this->renderChildren();
		}
		$marker = $this->inheritArguments();
		#var_dump($marker);
		$this->addMarker($marker);
	}
	
	public function addMarker($marker) {
		$layers = $this->get('layers');
		$last = array_pop(array_keys($layers));
		array_push($layers[$last], $marker);
		$this->reassign('layers', $layers);
	}
	
}


?>