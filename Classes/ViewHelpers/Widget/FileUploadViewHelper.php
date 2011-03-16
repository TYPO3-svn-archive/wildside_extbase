<?php 


class Tx_WildsideExtbase_ViewHelpers_FileUploadViewHelper extends Tx_WildsideExtbase_ViewHelpers_WidgetViewHelper {
	
	const NAMESPACE = 'dk.wildside.display.widget.FileUploadWidget';
	
	/**
	 * Render an entry for a Listener compatible with JS LocusController
	 * @param string $widget JS namespace of widget to use - override this if you subclassed dk.wildside.display.widget.FileUploadWidget in JS
	 * @param array $data Prefilled files
	 * @param string $class Extra CSS-classes to use
	 * @param string $title Title of the widget
	 * @param int $type TypeNum, if any, for building request URI
	 * @param string $template siteroot-relative path of template file to use - leave out for default
	 * @return string
	 */
	public function render($widget=self::NAMESPACE, $data=NULL, $class=NULL, $title=NULL, $templateFile=NULL) {
		$type = 4815163242;
		$controller = 'FileUpload';
		$action = 'upload';
		$plugin = 'API';
		$html = $this->renderChildren();
		if (strlen(trim($html)) == 0) {
			if ($templateFile === NULL) {
				$templateFile = t3lib_extMgm::extPath('wildside_extbase', 'Resources/Private/Templates/Widget/FileUploadWidget.html');
			}
			$template = $this->objectManager->get('Tx_Fluid_View_StandaloneView');
			$template->setTemplatePathAndFilename($templateFile);
			// $template->assign($var, $value);
			$html = $template->render();
		}
		return parent::render($widget, $controller, $action, $page, $plugin, $data, $class, $title, $type, $html);
	}
	
}


?>