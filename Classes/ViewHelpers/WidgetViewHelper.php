<?php

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
	 * @param string $controller Name of the controller this widget uses
	 * @param string $action Default action of the controller to call, can be overridden by widget JS
	 * @param int $page UID of page containing the controller, optional
	 * @param string $plugin Name of the extension containing the controller
	 * @param object $data Data of the model object, if any
	 * @param string $class Extra CSS-classes to use
	 * @param string $title Title of the widget
	 * @param int $type TypeNum, if any, for building request URI. Defaults to the build-in Bootstrap for WildsideExtbase - which responds in raw JSON format
	 * @param string $html InnerHTML, if any. Overrides renderChildren()
	 * @return string
	 */
	public function render(
			$widget = 'dk.wildside.display.widget.Widget',
			$controller=NULL,
			$action='update',
			$page=NULL,
			$plugin=NULL,
			$data=NULL,
			$class=NULL,
			$title=NULL,
			$type=4815162342,
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
		if ($data instanceof Tx_Extbase_DomainObject_AbstractDomainObject) {
			$obj->data = $this->getValues($data);
		} else {
			$obj->data = $data;
		}
		$json = json_encode($obj);
		$html = "<div class='wildside-extbase-widget {$class}'>
			<div class='wildside-extbase-json'>{$json}</div>
			{$html}
		</div>";
		
		return $html;
	}
	
	protected function getTemplate($templateFile, $default='Widget/Widget.html') {
		if ($templateFile === NULL) {
			$templateFile = t3lib_extMgm::extPath('wildside_extbase', 'Resources/Private/Templates/' . $default);
		}
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$template = $objectManager->get('Tx_Fluid_View_StandaloneView');
		$template->setTemplatePathAndFilename($templateFile);
		return $template;
	}
	
}

?>