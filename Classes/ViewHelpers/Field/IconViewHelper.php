<?php 







class Tx_WildsideExtbase_ViewHelpers_Field_IconViewHelper extends Tx_WildsideExtbase_ViewHelpers_FieldViewHelper {
	
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
	public function render($displayType='dk.wildside.display.field.Icon', $class=NULL) {
		$icon = $this->renderChildren();
		return parent::render($icon, $displayType);
	}
	
}


?>