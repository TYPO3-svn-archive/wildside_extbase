<?php

/**
 * Creates a Widget container
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_WidgetViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Render an entry for a Listener compatible with JS LocusController
	 * @param string $widget The identifier of the widget, used in serverside com. and by JS. If model object defines its own widget, this one will be ignored
	 * @param string $controller Name of the controller this widget uses
	 * @param string $action Default action of the controller to call, can be overridden by widget JS
	 * @param int $page UID of page containing the controller, optional
	 * @param string $plugin Name of the extension containing the controller
	 * @param array $data Data of the model object, if any
	 * @param string $class Extra CSS-classes to use
	 * @param string $title Title of the widget
	 * @param int $type TypeNum, if any, for building request URI
	 * @param string $html InnerHTML, if any. Overrides renderChildren()
	 * @return string
	 */
	public function render(
			$widget = 'dk.wildside.display.Widget',
			$controller=NULL,
			$action='update',
			$page=NULL,
			$plugin=NULL,
			$data=NULL,
			$class=NULL,
			$title=NULL,
			$type=0,
			$html=NULL
			) {
		if ($page === NULL) {
			$page = $GLOBALS['TSFE']->id;
		}
		if ($html === NULL) {
			$html = $this->renderChildren();
		}
		$obj = new stdClass();
		$obj->api = $GLOBALS['TSFE']->cObj->typoLink('', array('parameter' => $page, 'returnLast' => 'url', 'additionalParams' => "&type={$type}"));
		$obj->widget = $widget;
		$obj->controller = $controller;
		$obj->page = $page;
		$obj->title = $title;
		$obj->action = $action;
		
		if ($plugin) {
			$obj->plugin = $plugin;
		} else {
			$plugin = 'pi1';
			$extension = $this->controllerContext->getRequest()->getControllerExtensionName();
			$plugin = strtolower($plugin);
			$extension = strtolower($extension);
			$obj->plugin = "tx_{$extension}_{$plugin}";
		}
		if ($data) {
			$obj->data = $data;
		}
		$json = json_encode($obj);
		$html = "<div class='wildside-extbase-widget {$class}'>
			<div class='wildside-extbase-json'>{$json}</div>
			{$html}
		</div>";
		
		return $html;
	}
	
}

?>