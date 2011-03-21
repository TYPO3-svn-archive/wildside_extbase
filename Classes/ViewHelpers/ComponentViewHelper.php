<?php

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
	 * @return string
	 */
	public function render(
			$component='dk.wildside.display.Component',
			$controller=NULL,
			$action='update',
			$page=NULL,
			$plugin=NULL,
			$class=NULL,
			$strategy='eager'
		) {
		$html = $this->renderChildren();
		$obj = new stdClass();
		$obj->component = $component;
		$obj->controller = $controller;
		$obj->action = $action;
		$obj->pageUid = $pageUid;
		$obj->extensionName = $extensionName;
		$obj->title = $title;
		$obj->strategy = $strategy;
		$json = json_encode($obj);
		$html = "<div class='wildside-extbase-component {$class}'>
			<div class='wildside-extbase-json'>{$json}</div>
			{$html}
		</div>";
		return $html;
	}
	
}

?>