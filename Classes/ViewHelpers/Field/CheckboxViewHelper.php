<?php 







class Tx_WildsideExtbase_ViewHelpers_Field_CheckboxViewHelper extends Tx_WildsideExtbase_ViewHelpers_FieldViewHelper {
	
	/**
	 * Render the Field
	 * 
	 * @param string $displayType Type (WS JS domain style) of Field 
	 * @param string $name Name property of the Field
	 * @param string $value Value property of the Field
	 * @param string $class Class property of the Field
	 * @param boolean $checked Wether or not the checkbox is checked
	 * @param string $sanitizer WS JS Domain style reference to validator method
	 */
	public function render($displayType='dk.wildside.display.field.Checkbox', $name=NULL, $value=NULL, $class=NULL, $checked=FALSE, $sanitizer=NULL) {
		if ($checked == TRUE) {
			$checked = " checked='checked'";
		}
		$field = "<input type='checkbox' name='{$name}' class='checkbox {$class}' value='{$value}' {$checked}/>";
		return parent::render($field, $displayType, $name, $value, NULL, $sanitizer);
	}
	
}


?>