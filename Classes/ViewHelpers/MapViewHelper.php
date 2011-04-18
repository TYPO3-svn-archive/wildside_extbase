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
	
	protected $type = Tx_WildsideExtbase_ViewHelpers_InjectViewHelper::TYPE_JAVASCRIPT;
	
	protected $tagName = 'div';
	
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerUniversalTagAttributes();
		$this->registerTagAttribute('lat', 'float', 'Lattitude');
		$this->registerTagAttribute('lng', 'float', 'Longitude');
		$this->registerTagAttribute('name', 'string', 'Name');
		$this->registerTagAttribute('icon', 'string', 'Icon filename');
		$this->registerTagAttribute('iconCenterX', 'int', 'Icon pivot coordinate X');
		$this->registerTagAttribute('iconCenterY', 'int', 'Icon pivot coordinate Y');
	}
	
	/**
	 * @param string $api
	 * @param string $width
	 * @param string $height
	 * @param string backgroundColor Color used for the background of the Map div. This color will be visible when tiles have not yet loaded as the user pans. This option can only be set when the map is initialized.
	 * @param boolean disableDefaultUI Enables/disables all default UI. May be overridden individually.
	 * @param boolean disableDoubleClickZoom Enables/disables zoom and center on double click. Enabled by default.
	 * @param boolean draggable If false, prevents the map from being dragged. Dragging is enabled by default.
	 * @param string draggableCursor The name or url of the cursor to display on a draggable object.
	 * @param string draggingCursor The name or url of the cursor to display when an object is dragging.
	 * @param string keyboardShortcuts If false, prevents the map from being controlled by the keyboard. Keyboard shortcuts are enabled by default.
	 * @param boolean mapTypeControl The initial enabled/disabled state of the Map type control.
	 * @param float maxZoom The maximum zoom level which will be displayed on the map. If omitted, or set to null, the maximum zoom from the current map type is used instead.
	 * @param float minZoom The minimum zoom level which will be displayed on the map. If omitted, or set to null, the minimum zoom from the current map type is used instead.
	 * @param boolean noClear If true, do not clear the contents of the Map div.
	 * @param boolean panControl The enabled/disabled state of the pan control.
	 * @param boolean scaleControl The initial enabled/disabled state of the scale control.
	 * @param boolean scrollwheel If false, disables scrollwheel zooming on the map. The scrollwheel is enabled by default.
	 * @param boolean streetViewControl The initial enabled/disabled state of the Street View pegman control.
	 * @param float zoom The initial Map zoom level. Required.
	 * @param boolean zoomControl The enabled/disabled state of the zoom control.
	 */
	public function render(
			// CUSTOM parameters
			$api=NULL, 
			$width="500px", 
			$height="500px", 
			// next is Google Map parameters
			$backgroundColor=NULL,
			$disableDefaultUi=FALSE,
			$disableDoubleClickZoom=TRUE,
			$draggable=TRUE,
			$draggableCursor=NULL,
			$draggingCursor=NULL,
			$keyboardShortcuts=TRUE,
			$mapTypeControl=NULL,
			$maxZoom=NULL,
			$minZoom=NULL,
			$noClear=FALSE,
			$panControl=TRUE,
			$scaleControl=TRUE,
			$scrollWheel=TRUE,
			$streetViewControl=TRUE,
			$zoom=7,
			$zoomControl=TRUE
			) {
		if ($api === NULL) {
			$api = "http://maps.google.com/maps/api/js?v=3.2&sensor=true";
		}
		$min = 100000;
		$max = 999999;
		$elementId = 'gm' . rand($min, $max);
		
		$this->includeFile($api);
		$this->templateVariableContainer->add('layers', array());
		$this->templateVariableContainer->add('infoWindows', array());
		
		$this->inheritArguments();
		$this->renderChildren();
		
		$markers = $this->renderMarkers();
		
		$lat = $this->arguments['lat'] ? $this->arguments['lat'] : 56.5;
		$lng = $this->arguments['lng'] ? $this->arguments['lng'] : 10.6;
		
		$options = $this->getMapOptions();
		
		$init = <<< INIT
jQuery(document).ready(function() {
var myLatlng = new google.maps.LatLng({$lat}, {$lng});
var myOptions = {$options};
var infoWindow = infoWindow = new google.maps.InfoWindow();
var map = new google.maps.Map(document.getElementById("{$elementId}"), myOptions);
{$markers}

function wildsideExtbaseGoogleMapShowInfoWindow(event, content) {
	//console.warn(jQuery(event.currentTarget).data('infoWindow'));
    infoWindow.setContent(content);
    infoWindow.setPosition(event.latLng);
    infoWindow.open(map, markers[event.currentTarget.getAttribute('id')]);
    console.info(event.currentTarget);
    console.warn(content);
};
});
INIT;

		$css = <<< CSS
#{$elementId} {
	width: {$width};
	height: {$height};
}
CSS;

		$code = $this->wrap($init);
		$this->process($code, Tx_WildsideExtbase_ViewHelpers_InjectViewHelper::TYPE_JAVASCRIPT);
		
		// change type - next comes CSS inclusion
		$this->type = Tx_WildsideExtbase_ViewHelpers_InjectViewHelper::TYPE_STYLESHEET;
		
		$css = $this->wrap($css);
		$this->process($css, Tx_WildsideExtbase_ViewHelpers_InjectViewHelper::TYPE_STYLESHEET);
		
		$this->tag->addAttribute('id', $elementId);
		
		
		$this->tag->setContent('');
		
		$this->templateVariableContainer->remove('layers');
		
		return $this->tag->render();
	}
	
	public function get($name) {
		if ($this->templateVariableContainer->exists($name)) {
			return $this->templateVariableContainer->get($name);
		} else {
			return FALSE;
		}
	}
	
	public function reassign($name, $value) {
		if ($this->templateVariableContainer->exists($name)) {
			$this->templateVariableContainer->remove($name);
		}
		$this->templateVariableContainer->add($name, $value);
	}
	
	public function inheritArguments() {
		$config = $this->get('config');
		if ($config === FALSE) {
			$config = array();
		}
		$arguments = $this->getArguments();
		foreach ($arguments as $name=>$value) {
			#if (isset($config[$name]) == FALSE) {
				$config[$name] = $value;
			#}
		}
		$this->reassign('config', $config);
		return $config;
	}
	
	public function getArguments() {
		$args = array();
		$defs = $this->prepareArguments();
		foreach ($defs as $def) {
			$name = $def->getName();
			if ($this->arguments->hasArgument($name)) {
				$args[$name] = $this->arguments[$name];
			}
		}
		return $args;
	}
	
	public function renderMarkers() {
		$layers = $this->get('layers');
		$allMarkers = array();
		foreach ($layers as $name=>$markers) {
			foreach ($markers as $marker) {
				$markerId = uniqid('marker');
				$options = $this->getMarkerOptions($marker);
				
				#$obj = json_decode($options);
				#var_dump($options);
				#var_dump($obj);
				#exit();
				$str = "var {$markerId} = new google.maps.Marker($options); ";
				#$str .= "   console.info({$markerId});";
				if ($marker['infoWindow']) {
					$content = $marker['infoWindow'];
					$content = addslashes($content);
					#$str .= "    console.log('{$content}');";
					//$str .= "    jQuery(markers[{$i}]).data('infoWindow', '" . addslashes($options['infoWindow']) . "');";
					#$str .= "    google.maps.event.addListener({$markerId}, 'click', wildsideExtbaseGoogleMapShowInfoWindow);";
					$str .= "    google.maps.event.addListener({$markerId}, 'click', function(event) { infoWindow.setContent('{$content}'); infoWindow.setPosition(event.latLng); infoWindow.open(map, {$markerId}); });";
				}
				array_push($allMarkers, $str);
			}
		}
		return implode("\n", $allMarkers);
	}
	
	public function getOptions($object) {
		$lines = array();
		foreach ($object as $name=>$value) {
			if (is_numeric($value)) {
				// NOOP
			} else if (is_string($value)) {
				$value = "\"{$value}\"";
			} else if (is_null($value)) {
				continue;
			} else if (is_bool($value)) {
				$value = $value ? 'true' : 'false';
			}
			$lines[] = "{$name}:{$value}";
		}
		return $lines;
	}
	
	public function getMapOptions() {
		/*
		 * MAP OPTIONS OBJECT JS
		 *
		 * @param center 	LatLng 	The initial Map center. Required.
		 * @param mapTypeControlOptions 	MapTypeControlOptions 	The initial display options for the Map type control.
		 * @param mapTypeId 	MapTypeId 	The initial Map mapTypeId. Required.
		 * @param streetView 	StreetViewPanorama 	A StreetViewPanorama to display when the Street View pegman is dropped on the map. If no panorama is specified, a default StreetViewPanorama will be displayed in the map's div when the pegman is dropped.
		 * @param streetViewControlOptions 	StreetViewControlOptions 	The initial display options for the Street View pegman control.
		 * @param zoomControlOptions 	ZoomControlOptions 	The display options for the zoom control.
		 * @param panControlOptions 	PanControlOptions 	The display options for the pan control.
		 * @param scaleControlOptions 	ScaleControlOptions 	The initial display options for the scale control.
		 */
		$lines = array(
			"center: myLatlng",
        	"mapTypeId: google.maps.MapTypeId.ROADMAP",
		);
		$lines = array_merge($lines, $this->getOptions($this->getArguments()));
		return $this->objWrap($lines);
	}
	
	public function getMarkerOptions($marker) {
		$lines = array(
			"position: new google.maps.LatLng({$marker['lat']},{$marker['lng']})",
			"map: map",
			#shadow 	string|MarkerImage 	Shadow image
			#icon 	string|MarkerImage 	Icon for the foreground
			#shape MarkerShape Image map region definition used for drag/click.
		);
		$lines = array_merge($lines, $this->getOptions($marker));
		return $this->objWrap($lines);
	}
	
	public function objWrap($lines) {
		$str = "{".implode(", ", $lines)."}";
		return $str;
	}
	
	
	
}
?>