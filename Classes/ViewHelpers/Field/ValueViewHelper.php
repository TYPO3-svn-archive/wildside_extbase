<?php 







class Tx_WildsideExtbase_ViewHelpers_Field_ValueViewHelper extends Tx_WildsideExtbase_ViewHelpers_FieldViewHelper {
	
	/**
	 * Render the Field
	 * 
	 * @param string $displayType Type (WS JS domain style) of Field 
	 * @param string $name Name property of the Field
	 * @param string $value Value property of the Field
	 * @param string $class Class property of the Field
	 */
	public function render($displayType='dk.wildside.display.field.Value', $name=NULL, $value=NULL, $class=NULL) {
		if (strlen(trim($value)) == 0) {
			$value = 'Click to enter text';
		}
		$displayTypeFixed = str_replace(".", "-", $displayType);
		$field = "<div title='{$name}' class='{$class}'>{$value}</div>";
		return parent::render($field, $displayType, $name, $value);
	}
	
}


?>