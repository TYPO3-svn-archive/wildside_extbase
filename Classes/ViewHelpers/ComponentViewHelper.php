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

/**
 * Creates a Component container
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_ComponentViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Render an entry for a Listener compatible with JS LocusController
	 * @param string $component The identifier of the widget, used in serverside com. and by JS.
	 * @param string $controller Name of the controller this widget uses
	 * @param string $action Default action of the controller to call, can be overridden by widget JS
	 * @param int $page UID of page containing the controller, optional
	 * @param string $extensionName Name of the extension containing the controller
	 * @param string $class Extra CSS-classes to use
	 * @param string $strategy The saving strategy to use. "lazy" or "eager" - if "lazy" you need other means to issue sync, i.e. a Submit button
	 * @param object $object If specified, uses $object for Controller information. If ObjectStorage, if $strategy="lazy" and if "bulkUpdateAction" exists in target controller, bulk-update features in AJAX become active 
	 * @return string
	 */
	public function render(
			$component='dk.wildside.display.Component',
			$controller=NULL,
			$action='update',
			$page=NULL,
			$plugin=NULL,
			$class=NULL,
			$strategy='eager',
			$object=NULL
		) {
		if ($component == '') {
			$component = 'dk.wildside.display.Component';
		}
		$html = $this->renderChildren();
		$obj = new stdClass();
		$obj->displayType = $component;
		$obj->controller = $controller;
		$obj->action = $action;
		$obj->pageUid = $pageUid;
		$obj->extensionName = $extensionName;
		$obj->title = $title;
		$obj->strategy = $strategy;
		$obj->bulk = 0;
		if ($object instanceof Tx_Extbase_Persistence_ObjectStorage && $strategy == 'lazy') {
			// analyze for Controller name and type:
			$probe = $object->current();
			$probeClass = get_class($probe);
			$controllerClass = str_replace("_Domain_Model", "_Controller_", $probeClass) . "Controller";
			$bulkAction = "bulk{$action}Action";
			if (method_exists($controllerClass, $bulkAction)) {
				$obj->bulk = 1;
				$obj->action = $bulkAction;
			}
		}
		$json = $this->jsonService->encode($obj);
		$html = "<div class='wildside-extbase-component {$class}'>
			<div class='wildside-extbase-json'>{$json}</div>
			{$html}
		</div>";
		return $html;
	}
	
}

?>