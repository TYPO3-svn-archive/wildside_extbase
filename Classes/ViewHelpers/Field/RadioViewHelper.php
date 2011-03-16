<?php 







class Tx_WildsideExtbase_ViewHelpers_Field_RadioViewHelper extends Tx_WildsideExtbase_ViewHelpers_FieldViewHelper {
	
	/**
	 * Render the Field
	 * 
	 * @param string $displayType Type (WS JS domain style) of Field 
	 * @param string $name Name property of the Field
	 * @param string $value Value property of the Field
	 * @param string $class Class property of the Field
	 * @param array $options If multiple options, specify them here as value => label array
	 * @param string $selectedValue The pre-selected value among $options
	 */
	public function render(
			$displayType='dk.wildside.display.field.Radio', 
			$name=NULL, 
			$value=NULL, 
			$class=NULL, 
			array $options=array('No', 'Yes'), 
			$selectedValue=NULL) {
		$html = "<span class='input-radio-wrap'>";
		foreach ($options as $value=>$label) {
			if ($value == $selectedValue) {
				$checked = " checked='checked'";
			} else {
				$checked = '';
			}
			$field = "<label class='input-field-label'><span class='input-field-label-text'>{$label}</span> <input type='radio' name='{$name}' class='input-radio {$class}' value='{$value}' {$checked} /></label>";
			$html .= $field;
		}
		$html .= "</span>";
		return parent::render($html, $displayType, $name, $value);
	}
	
}


?>