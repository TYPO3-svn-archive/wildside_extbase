/***************************************************************
* DatePickerWidget - Gui Object
* 
* WSAPI interface for jQuery date picker
* 
***************************************************************/

dk.wildside.display.widget.DatePickerWidget = function(jQueryElement) {
	
	dk.wildside.display.widget.Widget.call(this, jQueryElement);
};

dk.wildside.display.widget.DatePickerWidget.prototype = new dk.wildside.display.widget.Widget();

/*
dk.wildside.display.widget.DatePickerWidget.prototype.setValue = function(value) {
	//this.fields[0].setValue(value);
	this.value = value;
};

dk.wildside.display.widget.DatePickerWidget.prototype.getValue = function() {
	//return this.fields[0].getValue();
	return this.value;
};
*/