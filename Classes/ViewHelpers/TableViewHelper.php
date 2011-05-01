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


class Tx_WildsideExtbase_ViewHelpers_TableViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractTagBasedViewHelper {
	
	/**
	 * @var Tx_WildsideExtbase_Utility_PropertyMapper $propertyMapper
	 */
	protected $propertyMapper;
	
	protected $tagName = 'table';
	
	protected $iconAsc = FALSE;
	
	protected $iconDesc = FALSE;
	
	protected $iconDefault = FALSE;
	
	public $rowClassPrefix = 'row';

	/**
	 * @param Tx_WildsideExtbase_Utility_PropertyMapper $mapper
	 */
	public function injectPropertyMapper(Tx_WildsideExtbase_Utility_PropertyMapper $mapper) {
		$this->propertyMapper = $mapper;
	}
	
	/**
	 * Initialization
	 * 
	 * @return void
	 */
	public function initializeArguments() {
		$this->registerUniversalTagAttributes();
		parent::initializeArguments();
	}
	
	/**
	 * Render method
	 * 
	 * @param int $cellspacing
	 * @param int $cellpadding
	 * @param string $iconAsc Icon file for ASC order indication
	 * @param string $iconDesc Icon file for DESC order indication
	 * @param string $iconDefault Icon file for sorting indication
	 * @param string $textExtraction Which method to use for text extraction. Valid values are "simple", "compex" or string name of a Javascript function you created
	 * @param array $data If specified, renders array $data as table rows using keys for headers
	 * @param array $headers If specified, uses $headers as array of header names
	 * @param array $objects If specified, considers $object an array of DomainObjects or associative arrays. If !$properties and !$annotationName then all properties are rendered
	 * @param array $properties If specified, uses array $properties as list of properties on each object to render as a row
	 * @param string $annotationName If specified, source code annotation (for example @myannotation) is used to determine which object properties to render as a row
	 * @param string $annotationValue If specified, source code annotation $annotationName must have $annotationValue as one of its listed attributes (for example @myannotation value1 value2 matches $annotationValue='value1' and $annotationValue='value2') 
	 * @return string
	 */
	public function render(
			$cellspacing=FALSE, 
			$cellpadding=FALSE, 
			$iconAsc=FALSE, 
			$iconDesc=FALSE, 
			$iconDefault=FALSE, 
			$textExtraction='simple',
			array $data=NULL,
			array $headers=NULL,
			array $objects=NULL,
			array $properties=NULL,
			$annotationName=NULL,
			$annotationValue=NULL
			) {
		
		if ($iconAsc === FALSE) {
			$iconAsc = t3lib_extMgm::extRelPath('wildside_extbase') . 'Resources/Public/Images/asc.gif';
		}
		
		if ($iconDesc === FALSE) {
			$iconDesc = t3lib_extMgm::extRelPath('wildside_extbase') . 'Resources/Public/Images/desc.gif';
		}
		
		if ($iconDefault === FALSE) {
			$iconDefault = t3lib_extMgm::extRelPath('wildside_extbase') . 'Resources/Public/Images/sort.gif';
		}
		
		$this->iconAsc = $iconAsc;
		$this->iconDesc = $iconDesc;
		$this->iconDefault = $iconDefault;
		
		$this->addClassAttribute();
		
		$this->addScripts();
		$this->addStyles();
		
		$thead = $this->renderHeaders($headers, $objects, $properties, $annotationName, $annotationValue);
		if ($data) {
			$tbody = $this->renderData($data, $properties);
		} else if ($objects) {
			$tbody = $this->renderObjects($objects, $properties, $annotationName, $annotationValue);
		} else {
			$tbody = $this->renderChildren();
		}
		
		if ($thead) {
			$content = "{$thead}{$tbody}";
		} else {
			$content = "{$tbody}";
		}
		#die($content);
		$this->tag->setContent($content);
		
		if ($cellspacing !== FALSE) {
			$this->tag->addAttribute('cellspacing', $cellspacing);
		}
		
		if ($cellpadding !== FALSE) {
			$this->tag->addAttribute('cellpadding', $cellpadding);
		}
		
		return $this->tag->render();
	}
	
	private function renderHeaders($headers, $objects, $properties, $annotationName, $annotationValue) {
		if (!$headers && !$objects && !$properties) {
			return NULL;
		}
		if ($objects && !$headers) {
			if ($properties) {
				$headers = $properties;
			} else {
				$values = $this->getValues($objects[0], $annotationName, $annotationValue);
				$headers = array_keys($values);
			}
			$headers = $this->translatePropertyNames($objects[0], $headers);
		}
		$html = "<thead>";
		foreach ($headers as $header) {
			$html .= "<th>{$header}</th>";
		}
		$html .= "</thead>";
		return $html;
	}
	
	private function renderObjects($objects, $properties, $annotationName, $annotationValue) {
		if (!$properties) {
			$values = $this->getValues($objects[0], $annotationName, $annotationValue);
			$properties = array_keys($values);
		}
		return $this->renderData($objects, $properties);
	}
	
	private function renderData($data, $properties) {
		$html = "<tbody>";
		foreach ($data as $item) {
			if (is_array($item)) {				
				$id = $item['id'];
			} else {
				$id = $item->getUid();
			}
			$html .= "<tr class='{$this->rowClassPrefix}{$id}'>";
			foreach ($properties as $property) {
				if (is_array($item)) {
					$value = $item[$property];
				} else {
					$getter = "get" . ucfirst($property);
					$value = $item->$getter();
				}
				$html .= "<td>{$value}</td>";
			}
			$html .= "</tr>";
		}
		$html .= "</tbody>";
		return $html;
	}
	
	private function getValues($object, $annotationName, $annotationValue) {
		if (!$annotationName) {
			$annotationName = "var";
			if (!$annotationValue) {
				$annotationValue = TRUE;
			}
		}
		$values = $this->propertyMapper->getValuesByAnnotation($object, $annotationName, $annotationValue);
		return $values;
	}
	
	private function translatePropertyNames($object, $properties) {
		return array_combine($properties, $properties);
	}
	
	/**
	 * Inject an additional classname in tag attributes
	 * @return void
	 */
	private function addClassAttribute() {
		if ($this->arguments['class']) {
			$classes = explode(' ', $this->arguments['class']);
		} else {
			$classes = array();
		}
		array_push($classes, 'wildside-extbase-sortable');
		$classNames = implode(' ', $classes);
		$this->tag->addAttribute('class', $classNames);
	}
	
	/**
	 * Attach scripts to header
	 * 
	 * @return void
	 */
	private function addScripts() {
		$scriptFile1 = t3lib_extMgm::extRelPath('wildside_extbase') . 'Resources/Public/Javascript/com/jquery/plugins/jquery.tablesorter.min.js';
		$scriptFile2 = t3lib_extMgm::extRelPath('wildside_extbase') . 'Resources/Public/Javascript/com/jquery/plugins/jquery.tablesorter.pager.js';
		
		$init = <<< INITSCRIPT
jQuery(document).ready(function() {
	var options = {
		widthFixed : true,
		widgets : ['zebra'],
		textExtraction : '{$this->arguments['textExtraction']}'
	};
	var pagerOptions = {
		container : jQuery('.wildside-extbase-sortable tfoot td')
	};
	jQuery('.wildside-extbase-sortable').tablesorter(options); //.tablesorterPager(pagerOptions);
});
INITSCRIPT;
		
		$injector = $this->objectManager->get('Tx_WildsideExtbase_ViewHelpers_Inject_JsViewHelper');
		$injector->render(NULL, $scriptFile1);
		$injector->render(NULL, $scriptFile2);
		$injector->render($init);
	}
	
	/**
	 * Add stylesheets
	 * 
	 * @return void
	 */
	private function addStyles() {
		$css = <<< CSS
.wildside-extbase-sortable th {
	cursor: pointer;
	background-repeat: no-repeat;
    background-position: center left;
    padding-left: 18px;
    text-align: left;
    background-image: url('{$this->iconDefault}');
}

.wildside-extbase-sortable td {
	padding: {$this->arguments['cellpadding']}px;
}

.wildside-extbase-sortable th.headerSortUp {
	background-image: url('{$this->iconAsc}');
}

.wildside-extbase-sortable th.headerSortDown {
	background-image: url('{$this->iconDesc}');
}

.wildside-extbase-sortable tr.even td,
.wildside-extbase-sortable th {
	background-color: #EDEDED;
}

CSS;
		
		$injector = $this->objectManager->get('Tx_WildsideExtbase_ViewHelpers_Inject_CssViewHelper');
		$injector->render(NULL, $css);
	}
	
}

?>