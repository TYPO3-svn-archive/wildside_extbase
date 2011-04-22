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
 * Creates a Widget container
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_WidgetViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Render an entry for a Listener compatible with JS LocusController
	 * @param string $widget The identifier of the widget, used in serverside com. and by JS. If model object defines its own widget, this one will be ignored
	 * @param string $name If specified, will be returned from the getName() method of the Widget instance in JS
	 * @param string $controller Name of the controller this widget uses
	 * @param string $action Default action of the controller to call, can be overridden by widget JS
	 * @param int $page UID of page containing the controller, optional
	 * @param string $plugin Name of the extension containing the controller
	 * @param object $data Data of the model object, if any
	 * @param string $class Extra CSS-classes to use
	 * @param string $title Title of the widget
	 * @param int $type TypeNum, if any, for building request URI. Defaults to the build-in Bootstrap for WildsideExtbase - which responds in raw JSON format
	 * @param string $html InnerHTML, if any. Overrides renderChildren()
	 * @param object $config Object containing base configuration
	 * @return string
	 */
	public function render(
			$widget = 'dk.wildside.display.widget.Widget',
			$name='widget',
			$controller=NULL,
			$action='update',
			$page=NULL,
			$plugin=NULL,
			$data=NULL,
			$class=NULL,
			$title=NULL,
			$type=4815162342,
			$html=NULL,
			$config=NULL
			) {
		if ($page === NULL) {
			$page = $GLOBALS['TSFE']->id;
		}
		$obj = new stdClass();
		$obj->api = "?type={$type}";
		$obj->displayType = $widget;
		$obj->controller = $controller;
		$obj->page = $page;
		$obj->title = $title;
		$obj->action = $action;
		$obj->name = $name;
		if (is_object($config)) {
			foreach ($config as $k=>$v) {
				$obj->$k = $v;
			}
		}
		
		if ($plugin) {
			$obj->plugin = $plugin;
		} else {
			$plugin = 'core';
			$extension = $this->controllerContext->getRequest()->getControllerExtensionName();
			$plugin = strtolower($plugin);
			$extension = strtolower($extension);
			$obj->plugin = "tx_{$extension}_{$plugin}";
		}
		if ($data instanceof Tx_Extbase_DomainObject_AbstractDomainObject) {
			$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
			$mapper = $objectManager->get('Tx_WildsideExtbase_Utility_PropertyMapper');
			$obj->data = $mapper->getValuesByAnnotation($data, 'json', TRUE);
		} else {
			$obj->data = $data;
		}
		$json = $this->jsonService->encode($obj);
		if ($html === NULL) {
			$html = $this->renderChildren();
		}
		
		$html = "<div class='wildside-extbase-widget {$class}'>
			<div class='wildside-extbase-json'>{$json}</div>
			{$html}
		</div>";
		
		return $html;
	}
	
	public function getTemplate($templateFile, $default='Widget/Widget.html') {
		if ($templateFile === NULL) {
			$templateFile = t3lib_extMgm::extPath('wildside_extbase', 'Resources/Private/Templates/' . $default);
		}
		return parent::getTemplate($templateFile);
	}
	
}

?>