<?php

/**
 * Date Picker
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_Widget_DatePickerViewHelper extends Tx_WildsideExtbase_ViewHelpers_WidgetViewHelper {
	
	const NAMESPACE = 'dk.wildside.display.widget.DatePickerWidget';
	
	/**
	 * Creates a jQuery datepicker element
	 * 
	 * @param string $widget JS namespace of widget to use - override this if you subclassed dk.wildside.display.widget.DatePickerWidget in JS
	 * @param string $date The selected date to use, either UNIX timestamp or strtotime-compat date string
	 * @param array $dates Array of dates to highlight
	 * @param string $name The name of the (hidden) input field
	 * @param string $class The class of the input field
	 * @param string $title The title of the Widget
	 * @param string $templateFile siteroot-relative path of template file to use
	 * @return string
	 */
	public function render(
			$widget=self::NAMESPACE, 
			$date=NULL,
			$dates=array(),
			$name=NULL,
			$class=NULL,
			$title=NULL,
			$templateFile=NULL
			) {
		
		$html = $this->renderChildren();
		if (strlen(trim($html)) == 0) {
			$defaultTemplateFile = 'Widget/DatePickerWidget.html';
			$template = $this->getTempate($templateFile, $defaultTemplateFile);
			$template->assign('date', $date);
			$template->assign('dates', $dates);
			$html = $template->render();
		}
		return parent::render($widget, $controller, $action, $page, $plugin, $data, $class, $title, $type, $html);
	}
}
	

?>