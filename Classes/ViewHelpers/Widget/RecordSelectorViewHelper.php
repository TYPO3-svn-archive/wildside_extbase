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

class Tx_WildsideExtbase_ViewHelpers_Widget_RecordSelectorViewHelper extends Tx_WildsideExtbase_ViewHelpers_WidgetViewHelper {
	
	const NAMESPACE = 'dk.wildside.display.widget.RecordSelectorWidget';
	
	private $name;
	private $table;
	private $query;
	private $titleField;
	private $storagePid;
	
	/**
	 * Render an entry for a Listener compatible with JS LocusController
	 * @param string $widget JS namespace of widget to use - override this if you subclassed dk.wildside.display.widget.RecordSelectorWidget in JS
	 * @param string $name Name of the (emulated) property
	 * @param array $data Prefilled records
	 * @param string $class Extra CSS-classes to use
	 * @param string $title Title of the widget
	 * @param int $page If specified, calls controller actions on this page uid
	 * @param string $templateFile siteroot-relative path of template file to use
	 * @param string $table The name of the table containing records 
	 * @param string $titleField Name of the field or dot-concatenated field names
	 * @param int $storagePid PID of the sysfolder or page where records are stored   
	 * @param int $type TypeNum, if any, for building request URI
	 * @param string $relationType Either '1:1', '1:n' or 'm:n' - affects how the field's values are returned. A single value is returned for 1:1, array of values for the others.
	 * @return string
	 */
	public function render(
			$widget=self::NAMESPACE,
			$name='records', 
			$data=NULL, 
			$class=NULL, 
			$title=NULL,
			$page=NULL,
			$templateFile=NULL,
			$table='pages',
			$titleField='title',
			$storagePid=0,
			$type=4815163242,
			$relationType='1:n') {
		$this->name = $name;
		$this->table = $table;
		$this->query = $query;
		$this->titleField = $titleField;
		$this->storagePid = $storagePid;
		$controller = 'RecordSelector';
		$action = 'upload';
		$plugin = 'tx_wildsideextbase_api';
		$html = $this->renderChildren();
		if (strlen(trim($html)) == 0) {
			$defaultTemplateFile = 'Widget/RecordSelectorWidget.html';
			$template = $this->getTemplate($templateFile, $defaultTemplateFile);
			$template->assign('available', $this->getPossibles());
			$template->assign('selected', $this->getSelected($data));
			// $template->assign($var, $value);
			$html = $template->render();
			#header("Content-type: text/plain");
			#echo $html;
			#exit();
		}
		return parent::render($widget, $name, $controller, $action, $page, $plugin, $data, $class, $title, $type, $html);
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