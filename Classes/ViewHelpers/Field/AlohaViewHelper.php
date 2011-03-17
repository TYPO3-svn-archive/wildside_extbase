<?php 







class Tx_WildsideExtbase_ViewHelpers_Field_AlohaViewHelper extends Tx_WildsideExtbase_ViewHelpers_FieldViewHelper {
	
	/**
	 * Render the Field
	 * 
	 * @param string $displayType Type (WS JS domain style) of Field 
	 * @param string $name Name property of the Field
	 * @param string $value Value property of the Field
	 * @param string $class Class property of the Field
	 * @param string $type Type (input, hidden, radio, checkbox) of the <input> field
	 * @param string $sanitizer WS JS Domain style reference to validator method
	 * @param string $tag Tagname to use for rendered container
	 */
	public function render($displayType='dk.wildside.display.field.Aloha', $name=NULL, $value=NULL, $class=NULL, $type='input', $sanitizer=NULL, $tag='p') {
		if (strlen(trim($value)) == 0) {
			$value = 'Click to enter text';
		}
		$field = "<{$tag} class='aloha {$class}'>{$value}</{$tag}>";
		
		return parent::render($field, $displayType, $name, $value, NULL, $sanitizer);
	}
	
}


?>