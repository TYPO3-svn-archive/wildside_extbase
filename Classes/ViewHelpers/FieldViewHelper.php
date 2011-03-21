<?php 







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
	 */
	public function render($field=NULL, $displayType='dk.wildside.display.Field', $name=NULL, $value=NULL, $class=NULL, $sanitizer=NULL) {
		$json = new stdClass();
		$json->displayType = $displayType;
		$json->name = $name;
		$json->value = $value;
		if ($sanitizer !== NULL) {
			$json->sanitizer = $sanitizer;
		} else {
			$json->sanitizer = 'noop'; // no-operation is default - returns value unchanged
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