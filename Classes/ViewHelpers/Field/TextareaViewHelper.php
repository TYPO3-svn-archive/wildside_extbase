<?php 







class Tx_WildsideExtbase_ViewHelpers_Field_TextareaViewHelper extends Tx_WildsideExtbase_ViewHelpers_FieldViewHelper {
	
	/**
	 * Render the Field
	 * 
	 * @param string $displayType Type (WS JS domain style) of Field 
	 * @param string $name Name property of the Field
	 * @param string $value Value property of the Field
	 * @param string $class Class property of the Field
	 */
	public function render($displayType='dk.wildside.display.field.Textarea', $name=NULL, $value=NULL, $class=NULL) {
		$field = "<textarea name='{$name}' class='textarea-{$type} {$class}'>{$value}</textarea>";
		return parent::render($field, $displayType, $name, $value);
	}
	
}


?>