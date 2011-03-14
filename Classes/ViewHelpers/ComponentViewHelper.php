<?php

/**
 * Creates a Component container
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_ComponentViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Render an entry for a Listener compatible with JS LocusController
	 * @param string $component The identifier of the widget, used in serverside com. and by JS.
	 * @param string $controller Name of the controller this widget uses
	 * @param string $action Default action of the controller to call, can be overridden by widget JS
	 * @param int $page UID of page containing the controller, optional
	 * @param string $extensionName Name of the extension containing the controller
	 * @param string $class Extra CSS-classes to use
	 * @return string
	 */
	public function render(
			$component = 'Dk_Wildside_Display_Component',
			$controller=NULL,
			$action='update',
			$page=NULL,
			$plugin=NULL,
			$class=NULL
		) {
		$this->includes();
		$html = $this->renderChildren();
		$obj = new stdClass();
		$obj->component = $component;
		$obj->controller = $controller;
		$obj->action = $action;
		$obj->pageUid = $pageUid;
		$obj->extensionName = $extensionName;
		$obj->title = $title;
		$json = json_encode($obj);
		$html = "<div class='wildside-extbase-component {$class}'>
			<div class='wildside-extbase-json'>{$json}</div>
			{$html}
		</div>";
		return $html;
	}
	
	private function includes() {
		$jsBasePath = t3lib_extMgm::siteRelPath('wildside_extbase') . 'Resources/Public/Javascript/';
		$files = array(
			'dk/wildside/util/Iterator.js',
			'dk/wildside/util/Configuration.js',
			'dk/wildside/event/WidgetEvent.js',
			'dk/wildside/event/EventDispatcher.js',
			'dk/wildside/net/Request.js',
			'dk/wildside/net/Response.js',
			'dk/wildside/net/Dispatcher.js',
			'dk/wildside/net/Responder.js',
			'dk/wildside/display/DisplayObject.js',
			'dk/wildside/display/Component.js',
			'dk/wildside/display/Control.js',
			'dk/wildside/display/Widget.js',
		);
		$includer = t3lib_div::makeInstance('Tx_WildsideExtbase_ViewHelpers_Inject_JsViewHelper');
		foreach ($files as $file) {
			$includer->render(NULL, $jsBasePath.$file);
		}
		return TRUE;
	}
	
}

?>