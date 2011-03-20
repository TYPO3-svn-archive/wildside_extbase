<?php 

class Tx_WildsideExtbase_ViewHelpers_Widget_RecordSelectorViewHelper extends Tx_WildsideExtbase_ViewHelpers_WidgetViewHelper {
	
	const NAMESPACE = 'dk.wildside.display.widget.RecordSelectorWidget';
	
	private $table;
	private $query;
	private $titleField;
	private $storagePid;
	
	/**
	 * Render an entry for a Listener compatible with JS LocusController
	 * @param string $widget JS namespace of widget to use - override this if you subclassed dk.wildside.display.widget.FileUploadWidget in JS
	 * @param array $data Prefilled records
	 * @param string $class Extra CSS-classes to use
	 * @param string $title Title of the widget
	 * @param int $page If specified, calls controller actions on this page uid
	 * @param string $template siteroot-relative path of template file to use
	 * @param string $table The name of the table containing records 
	 * @param string $titleField Name of the field or dot-concatenated field names
	 * @param int $storagePid PID of the sysfolder or page where records are stored   
	 * @param int $type TypeNum, if any, for building request URI
	 * @return string
	 */
	public function render(
			$widget=self::NAMESPACE, 
			$data=NULL, 
			$class=NULL, 
			$title=NULL,
			$page=NULL,
			$templateFile=NULL,
			$table='pages',
			$titleField=NULL,
			$storagePid=0,
			$type=4815163242) {
				
		$this->table = $table;
		$this->query = $query;
		$this->titleField = $titleField;
		$this->storagePid = $storagePid;
		$controller = 'RecordSelector';
		$action = 'upload';
		$plugin = 'API';
		$html = $this->renderChildren();
		if (strlen(trim($html)) == 0) {
			if ($templateFile === NULL) {
				$templateFile = t3lib_extMgm::extPath('wildside_extbase', 'Resources/Private/Templates/Widget/RecordSelectorWidget.html');
			}
			$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
			$template = $objectManager->get('Tx_Fluid_View_StandaloneView');
			$template->setTemplatePathAndFilename($templateFile);
			$template->assign('available', $this->getPossibles());
			$template->assign('selected', $this->getSelected($data));
			// $template->assign($var, $value);
			$html = $template->render();
		}
		return parent::render($widget, $controller, $action, $page, $plugin, $data, $class, $title, $type, $html);
	}
	
	private function getPossibles() {
		return $this->getRecords();
	}
	
	private function getSelected($values) {
		if (count($values) >= 1) {
			$condition = "uid IN (" . implode(',', $values) . ")";
		} else {
			$condition = "1=0";
		}
		return $this->getRecords($condition);
	}
	
	private function getRecords($condition='1=1') {
		$condition .= " AND deleted = 0";
		if ($this->table == 'fe_users') {
			$condition .= " AND disable = 0";
		} else {
			$condition .= " AND hidden = 0";
		}
		if ($this->storagePid) {
			$condition .= " AND pid = '{$this->storagePid}'";
		}
		$array = array();
		#die($condition);
		$fields = implode(', ', array_merge(explode('.', $this->titleField), array('uid')));
		$result = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $this->table, $condition);
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)) {
			$title = $row[$this->titleField];
			$array[$row['uid']] = $title;
		}
		echo mysql_error();
		#var_dump($array);
		return $array;
	}
	
	
	
	
	
}

?>