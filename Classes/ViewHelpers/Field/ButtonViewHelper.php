<?php 







class Tx_WildsideExtbase_ViewHelpers_Field_ButtonViewHelper extends Tx_WildsideExtbase_ViewHelpers_FieldViewHelper {
	
	/**
	 * Render the Field
	 * 
	 * @param string $displayType Type (WS JS domain style) of Field 
	 * @param string $name Name property of the Field
	 * @param string $value Value property of the Field
	 * @param string $class Class property of the Field
	 * @param string $type The type (button, reset, submit) of the <button> tag created
	 * @param string $label The text on the button itself
	 * @param string $sanitizer WS JS Domain style reference to validator method
	 */
	public function render($displayType='dk.wildside.display.field.Button', $name=NULL, $value=NULL, $class=NULL, $type='button', $label=NULL, $sanitizer=NULL) {
		if ($label === NULL) {
			$label = $this->renderChildren();
		}
		if (trim($label) == '') {
			$label = 'button';
		}
		$field = "<button type='{$type}' name='{$name}' class='{$class}'>{$label}</button>";
		return parent::render($field, $displayType, $name, $value, NULL, $sanitizer);
	}
	
}


?>