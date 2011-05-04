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
		$imagePath = t3lib_extMgm::extRelPath('wildside_extbase') . 'Resources/Public/Images/';
		$i18n = array(
			'oPaginate' => array(
				'sFirst' => "First",
				'sLast' => "Last",
				'sPrevious' => "Previous",
				'sNext' => "Next"
			),
			'sEmptyTable' => 'Nothing to display',
			'sInfo' => "Showing _START_ to _END_ of _TOTAL_ entries",
			'sInfoEmpty' => "No table information to display",
			'sInfoFiltered' => "- filtering from _MAX_ entries",
			'sInfoPostFix' => "",
			'sLengthMenu' => "Show _MENU_ items",
			'sProcessing' => "",
			'sSearch' => "Filter records:",
			'sUrl' => "",
			'sZeroRecords' => "Nothing to display - no visible table content" 
			
		);
		$this->registerUniversalTagAttributes();
		$this->registerArgument('cellspacing', 'int', 'Cell spacing', FALSE);
		$this->registerArgument('cellpadding', 'int', 'Cell padding', FALSE);
		$this->registerArgument('iconAsc', 'string', 'Icon for sort ascending', FALSE, "{$imagePath}asc.gif");
		$this->registerArgument('iconDesc', 'string', 'Icon for sort descending', FALSE, "{$imagePath}desc.gif");
		$this->registerArgument('iconDefault', 'string', 'Default icon for sorting', FALSE, "{$imagePath}sort.gif");
		$this->registerArgument('textExtraction', 'string', 'Which method to use for text extraction. Valid values are "simple", "compex" or string name of a Javascript function you created', FALSE);
		$this->registerArgument('data', 'array', 'If specified, renders array $data as table rows using keys for headers', FALSE);
		$this->registerArgument('headers', 'array', 'If specified, uses $headers as array of header names', FALSE);
		$this->registerArgument('objects', 'array', 'If specified, considers $object an array of DomainObjects or associative arrays. If !$properties and !$annotationName then all properties are rendered', FALSE);
		$this->registerArgument('properties', 'array', 'If specified, uses array $properties as list of properties on each object to render as a row', FALSE);
		$this->registerArgument('annotaitonName', 'string', 'If specified, source code annotation (for example @myannotation) is used to determine which object properties to render as a row', FALSE);
		$this->registerArgument('annotationValue', 'string', 'If specified, source code annotation $annotationName must have $annotationValue as one of its listed attributes (for example @myannotation value1 value2 matches $annotationValue="value1" and $annotationValue="value2")', FALSE);
		$this->registerArgument('sortable', 'boolean', 'If TRUE, makes table sortable', FALSE, TRUE);
		$this->registerArgument('dateFormat', 'string', 'Format (php date() notation) to use when rendering DateTime objects', FALSE, 'Y-m-d H:i');
		$this->registerArgument('labelField', 'string', 'Name of the property on objects in the $objects array/ObjectStorage which contains a "name"-type identifier for each object. NOTE: this property is used to render names of relations, too!', FALSE, 'name');
		$this->registerArgument('section', 'string', 'If specified, will render the section you choose from the DomainObject template files based on the type of object. This section name is also used to render relational properties. For ObjectStorage, template "List.html" is used - for instances, "Show.html" is used.', FALSE, NULL);
		$this->registerArgument('aaSorting', 'string', 'jQuery DataTable aaSorting notation format column sorting setup - depends on sortable=TRUE', FALSE, '[[ 0, "asc" ]]');
		$this->registerArgument('oLanguage', 'array', 'Internationalization. See DataSorter jQuery plugin for string names and scopes - depends on sortable=TRUE', FALSE, $i18n);
		$this->registerArgument('iDisplayLength', 'int', 'Length of listing (best combiend with bPaginate=TRUE; depends on sortable=TRUE)', FALSE, -1);
		$this->registerArgument('bPaginate', 'boolean', 'Display pagination change options - depends on sortable=TRUE', FALSE, TRUE);
		$this->registerArgument('bSaveState', 'boolean', 'Set to TRUE to save the state of the table in a cookie', FALSE, FALSE);
		$this->registerArgument('bFilter', 'boolean', 'Display filtering search box - depends on sortable=TRUE', FALSE, TRUE);
		$this->registerArgument('bInfo', 'boolean', 'Display table information - depends on sortable=TRUE', FALSE, TRUE);
		$this->registerArgument('sPaginationType', 'string', 'Which paginateion method to use. "two_buttons" or "full_numbers", default "full_numbers"', FALSE, 'full_numbers');
		$this->registerArgument('aLengthMenu', 'string', 'aLengthMenu-format notation for the "display X items" dropdown. See DataTables jQuery plugin documentation.', FALSE, '[[20, 50, 100, -1], [20, 50, 100, "-"]]');
		parent::initializeArguments();
	}
	
	/**
	 * Render method
	 * 
	 * @return string
	 */
	public function render() {
		#return var_export($this->arguments['data'], TRUE);
		
		$this->addClassAttribute();
		if ($this->arguments['sortable']) {
			$this->addScripts();
			$this->addStyles();
		}
		
		$thead = $this->renderHeaders();
		if ($this->arguments['data']) {
			$properties = count($this->arguments['properties']) > 0 ? $this->arguments['properties'] : array_keys($this->arguments['data']);
			$tbody = $this->renderData($this->arguments['data'], $properties);
		} else if ($this->arguments['objects']) {
			$tbody = $this->renderObjects();
		} else {
			$tbody = $this->renderChildren();
		}
		
		if ($thead) {
			$content = "{$thead}{$tbody}";
		} else {
			$content = "{$tbody}";
		}
		
		$this->tag->setContent($content);
		
		if ($cellspacing !== FALSE) {
			$this->tag->addAttribute('cellspacing', $this->arguments['cellspacing']);
		}
				
		if ($cellpadding !== FALSE) {
			$this->tag->addAttribute('cellpadding', $this->arguments['cellpadding']);
		}
		
		return $this->tag->render();
	}
	
	/**
	 * Render table headers based on supplied arguments
	 * @return string
	 */
	private function renderHeaders() {
		$data = $this->arguments['data'];
		$headers = $this->arguments['headers'];
		$objects = $this->arguments['objects'];
		$properties = $this->arguments['properties'];
		if (!$headers && !$objects && !$properties && !$data) {
			return NULL;
		}
		if ($objects && !$headers) {
			if ($properties) {
				$headers = $properties;
			} else {
				$values = $this->getValues($objects[0]);
				$headers = array_keys($values);
			}
			$headers = $this->translatePropertyNames($objects[0], $headers);
		}
		if ($data && !$headers) {
			if ($properties) {
				$headers = $properties;
			} else {
				$headers = array_keys($data[0]);
			}
		}
		$html = "<thead>";
		foreach ($headers as $header) {
			$html .= "<th>{$header}</th>";
		}
		$html .= "</thead>";
		return $html;
	}
	
	/**
	 * Render objects - convert to data array then forward to renderData()
	 * @return string
	 */
	private function renderObjects() {
		$objects = $this->arguments['objects'];
		$properties = $this->arguments['properties'];
		if (!$properties) {
			$values = $this->getValues($objects[0]);
			$properties = array_keys($values);
		}
		return $this->renderData($values, $properties);
	}
	
	/**
	 * Render an array of (converted) data nodes based on $properties
	 * @param array $data
	 * @param array $properties
	 * @return string
	 */
	private function renderData($data, $properties) {
		$html = "<tbody>";
		foreach ($data as $item) {
			if (is_array($item)) {				
				$id = $item['id'];
			} else if (is_object($item) && method_exists($item, 'getUid')) {
				$id = $item->getUid();
			} else if (is_object) {
				$id = $item->uid;
			}
			$html .= "<tr class='{$this->rowClassPrefix}{$id}'>";
			foreach ($properties as $property) {
				$value = $this->renderValue($item, $property);
				$html .= "<td>{$value}</td>";
			}
			$html .= "</tr>\n";
		}
		$html .= "</tbody>";
		return $html;
	}
	
	/**
	 * Render a single value (a cell's content) based on type and rendering configuration
	 * @param mixed $value
	 * @return string
	 */
	private function renderValue($item, $property) {
		$getter = "get" . ucfirst($property);
		$labelField = $this->arguments['labelField'];
		$section = $this->arguments['section'];
		
		// reading value
		if (is_array($item)) {
			$value = $item[$property];
		} else if (is_object($item) && method_exists($item, $getter)) {
			$value = $item->$getter();
		} else if (is_object($item)) {
			$value = $item->$property;
		} else {
			$value = (string) $value;
		}
		
		// rendering value
		if ($value instanceof DateTime) {
			$value = (string) $value->format($this->arguments['dateFormat']);
		} else if ($value instanceof Tx_Extbase_Persistence_ObjectStorage) {
			// render the value as a CSV list of names based on labelField argument
			$names = array();
			foreach ($value as $child) {				
				array_push($names, $this->renderValue($value, $labelField));
			}
			$value = implode(', ', $names);
		} else if ($value instanceof Tx_Extbase_DomainObject_AbstractDomainObject) {
			if ($section) {
				$value = $this->renderDomainObjectTemplateSection($value, $section);
			} else {
				$hasGetter = method_exists($value, $getter);
				$value = ($hasGetter ? $value->$getter() : strval($value) . " - property '{$labelField}' does not exist.");
			}
		}
		
		return (string) $value;
	}
	
	/**
	 * Render a single <f:section> from the DomainObject template (Resources/Private/Templates).
	 * Extensionname etc. is detected from DomainObject's class name
	 * @param mixed $object Either a single DomainObject or an ObjectStorage of DomainObjects
	 * @param string $section
	 */
	private function renderDomainObjectTemplateSection($object, $section) {
		$string = "";
		if ($object instanceof Tx_Extbase_Persistence_ObjectStorage) {
			foreach ($object as $child) {
				$string .= $this->renderDomainObjectTemplateSection($child, $section);
			}
		} else if ($object instanceof Tx_Extbase_DomainObject_AbstractDomainObject) {
			$template = $this->objectManager->get('Tx_Fluid_View_TemplateView');
			$string = $template->render($section);
		}
	}
	
	/**
	 * Get values of a DomainObject based on annotations
	 * @param Tx_Extbase_DomainObject_AbstractDomainObject $object
	 * @return array
	 */
	private function getValues($object) {
		$annotationName = $this->arguments['annotationName'];
		$annotaionValue = $this->arguments['annotationValue'];
		if (!$annotationName) {
			$annotationName = "var";
			if (!$annotationValue) {
				$annotationValue = TRUE;
			}
		}
		$values = $this->propertyMapper->getValuesByAnnotation($object, $annotationName, $annotationValue, FALSE);
		return $values;
	}
	
	/**
	 * If possible, render human-readable column names based on i18n etc.
	 * @param Tx_Extbase_DomainObject_AbstractDomainObject $object
	 * @param array $properties
	 */
	private function translatePropertyNames($object, $properties) {
		return array_combine($properties, $properties);
	}
	
	/**
	 * return a JSON-valid representation of a PHP-"boolean" which can be TRUE/FALSE or 1/0
	 * @param mixed $bool
	 */
	private function jsBoolean($bool) {
		return ($bool ? 'true' : 'false'); 
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
		if ($this->arguments['sortable']) {
			array_push($classes, 'wildside-extbase-sortable');
		}
		$classNames = implode(' ', $classes);
		$this->tag->addAttribute('class', $classNames);
	}
	
	/**
	 * Attach scripts to header
	 * 
	 * @return void
	 */
	private function addScripts() {
		$scriptFile1 = t3lib_extMgm::extRelPath('wildside_extbase') . 'Resources/Public/Javascript/com/jquery/plugins/jquery.dataTables.min.js';
		
		$bPaginate = $this->jsBoolean($this->arguments['bPaginate']);
		$bFilter = $this->jsBoolean($this->arguments['bFilter']);
		$bInfo = $this->jsBoolean($this->arguments['bInfo']);
		$bSaveState = $this->jsBoolean($this->arguments['bSaveState']);
		$oLanguage = json_encode($this->arguments['oLanguage']);
		
		$init = <<< INITSCRIPT
var tableSorter;
jQuery(document).ready(function() {
	tableSorter = jQuery('.wildside-extbase-sortable').dataTable( {
		"aaSorting" : {$this->arguments['aaSorting']},
		"bPaginate" : {$bPaginate},
		"bFilter" : {$bFilter},
		"bSaveState" : {$bSaveState},
		"bInfo" : {$bInfo},
		"oLanguage" : {$oLanguage},
		"iDisplayLength" : {$this->arguments['iDisplayLength']},
		"aLengthMenu" : {$this->arguments['aLengthMenu']},
		"sPaginationType" : "{$this->arguments['sPaginationType']}",
	} );
} );	

INITSCRIPT;
		
		$injector = $this->objectManager->get('Tx_WildsideExtbase_ViewHelpers_Inject_JsViewHelper');
		$injector->render(NULL, $scriptFile1);
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
    background-image: url('{$this->arguments['iconDefault']}');
}

.wildside-extbase-sortable td {
	padding: {$this->arguments['cellpadding']}px;
}

.wildside-extbase-sortable th.sorting_asc {
	background-image: url('{$this->arguments['iconAsc']}');
}

.wildside-extbase-sortable th.sorting_desc {
	background-image: url('{$this->arguments['iconDesc']}');
}

.wildside-extbase-sortable tr.even td,
.wildside-extbase-sortable th {
	background-color: #EDEDED;
}

.wildside-extbase-sortable tr.off {
	display: none;
}

CSS;
		
		$file1 = 
		
		$injector = $this->objectManager->get('Tx_WildsideExtbase_ViewHelpers_Inject_CssViewHelper');
		
		
		$injector->render(NULL, $css);
	}
	
}

?>