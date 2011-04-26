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
	
	protected $tagName = 'table';
	
	protected $iconAsc = FALSE;
	
	protected $iconDesc = FALSE;
	
	protected $iconDefault = FALSE;
	
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
	 * @return string
	 */
	public function render($cellspacing=FALSE, $cellpadding=FALSE, $iconAsc=FALSE, $iconDesc=FALSE, $iconDefault=FALSE, $textExtraction='simple') {
		
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
		
		$children = $this->renderChildren();
		
		$this->tag->setContent($children);
		
		if ($cellspacing !== FALSE) {
			$this->tag->addAttribute('cellspacing', $cellspacing);
		}
		
		if ($cellpadding !== FALSE) {
			$this->tag->addAttribute('cellpadding', $cellpadding);
		}
		
		return $this->tag->render();
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
		widthFixed : false,
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
    background-position: center right;
    padding-right: 18px;
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