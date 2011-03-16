<?php 







class Tx_WildsideExtbase_ViewHelpers_Field_SelectViewHelper extends Tx_WildsideExtbase_ViewHelpers_FieldViewHelper {
	
	/**
	 * Render the Field
	 * 
	 * @param string $displayType Type (WS JS domain style) of Field 
	 * @param string $name Name property of the Field
	 * @param string $value Value property of the Field
	 * @param string $class Class property of the Field
	 * @param array $options If multiple options, specify them here as value => label array
	 * @param string $selectedValue The pre-selected value among $options
	 * @param boolean $multi Whether or not this element allows multiple selections
	 * @param integer $size Size (height) of the selector. If null or 1, it will be a regular dropdown box.
	 */
	public function render(
			$displayType='dk.wildside.display.field.Select', 
			$name=NULL, 
			$value=NULL, 
			$class=NULL, 
			array $options=array('No', 'Yes'), 
			$selectedValue=NULL,
			$multi=FALSE,
			$size=NULL) {
		
		$html = "<select name='{$name}' class='{$class}'" . ($size && $size > 1 ? " size='{$size}'" : "") . ($multi ? " multiple='true'" : "") . ">";
		foreach ($options as $value=>$label) {
			if ($value == $selectedValue) {
				$selected = " selected='selected'";
			} else {
				$selected = '';
			}
			$field = "<option value='{$value}' {$selected}>{$label}</option>";
			$html .= $field;
		}
		$html .= "</select>";
		return parent::render($html, $displayType, $name, $value);
	}
	
}


?>