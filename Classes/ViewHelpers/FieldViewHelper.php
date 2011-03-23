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



class Tx_WildsideExtbase_ViewHelpers_FieldViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Render the Field
	 * 
	 * @param string $field If specified, will be used as pre-rendered field and will override other parameters
	 * @param string $displayType Type (WS JS domain style) of Field
	 * @param string $name Name property of the Field
	 * @param string $value Value property of the Field
	 * @param string $class Class property of the Field
	 * @param string $sanitizer WS JS Domain style reference to validator method
	 * @param object $config Optional object of extra values to add to JSON config
	 */
	public function render($field=NULL, $displayType='dk.wildside.display.Field', $name=NULL, $value=NULL, $class=NULL, $sanitizer=NULL, $config=NULL) {
		$json = new stdClass();
		$json->displayType = $displayType;
		$json->name = $name;
		$json->value = $value;
		if ($sanitizer !== NULL) {
			$json->sanitizer = $sanitizer;
		} else {
			$json->sanitizer = 'noop'; // no-operation is default - returns value unchanged
		}
		// load additional - or overridden - config from visible properties of $config
		if ($config) {
			foreach ($config as $k=>$v) {
				$json->$k = $v;
			}
		}
		$jsonString = json_encode($json);
		if ($field === NULL) {
			// check for the last part of $displayType
			$subClass = array_pop(explode('.', $displayType));
			$subClassName = "Tx_WildsideExtbase_ViewHelpers_Field_{$subClass}";
			// if found, use render() method of subclass to render $field
			$instance = $this->objectManager->get($subClassName);
			if ($instance) {
				$field = $instance->render($displayType, $name, $value, $class); 
			}
		}
		$html = "<span class='wildside-extbase-field'>";
		$html .= "<div class='wildside-extbase-json'>{$jsonString}</div>";
		$html .= $field;
		$html .= "</span>";
		return $html;
	}
	
}


?>