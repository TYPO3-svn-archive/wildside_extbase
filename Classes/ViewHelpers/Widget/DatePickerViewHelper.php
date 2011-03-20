<?php

/**
 * Date Picker
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_WildsideExtbase_ViewHelpers_Widget_DatePickerViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Creates a jQuery datepicker element
	 * 
	 * @param string $date The date to use, either UNIX timestamp or strtotime-compat date string
	 * @param string $name The name of the (hidden) input field
	 * @param string $class The class of the input field
	 * @param string $class The ID of the input field
	 * @param string $renderField Whether or not to render the input field
	 * @return string
	 */
	public function render($date=NULL, $name=NULL, $class=NULL, $id=NULL, $renderField=TRUE) {
		
		$injector = t3lib_div::makeInstance("Tx_WildsideExtbase_ViewHelpers_Inject_JsViewHelper");
		
		$code = "
			var wsDatePickerTargets = [];
			var wsDatePickerFormat = 'mm/dd/yy';
			jQuery(document).ready(function() { wsDatePickerBootstrapper(wsDatePickerTargets); });
			function wsDatePickerBootstrapper(fields) {
				if (typeof(fields) != 'object') {
					fields = [fields];
				};
				
				for (i = 0; i < fields.length; i++) {
					var t = jQuery('#' + fields[i]);
					var newField = jQuery(\"<input type='hidden' class='hiddenDateField'/>\");
					
					var val = t.val();
					var rawVal = new Date(jQuery.datepicker.parseDate(wsDatePickerFormat, val));
					var elapsedMS = rawVal.getTime();
					if (elapsedMS < 0) elapsedMS = 0;
					newField.val(elapsedMS);
					
					t.before(newField);
					t.datepicker({
						altField : newField,
						altFormat : '@',
						dateFormat : wsDatePickerFormat
					});
				};
			};
		";
		$key = "wildside_datepicker_inline_bootstrap";
		$injector->render($code, NULL, TRUE, $key);

		// Only render the input field if we need to. Otherwise, this call would just've been
		// made to bootstrap the datepicker, which is handled above.
		if ($renderField) {
			if ($id) {
				// Inject name of particular input field name
				$code = "wsDatePickerTargets.push('{$id}');";
				$injector->render($code);
			}
			
			$html = "<input class='jQuery-datepicker {$class}' type='text' name='{$name}' value='{$date}' id='{$id}' />";
			return $html;
		} else {
			return "";
		}
	}
}
	

?>