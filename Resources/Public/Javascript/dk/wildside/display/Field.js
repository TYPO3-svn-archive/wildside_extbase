

Dk_Wildside_Display_Field = function(name, jQueryElement) {
	this.name = name;
	this.jQueryElement = jQueryElement;
	this.value = this.getValue();
};

Dk_Wildside_Display_Field.prototype = new Dk_Wildside_Display_DisplayObject();

Dk_Wildside_Display_Field.prototype.setValue = function(val) {
	this.value = val;
	this.jQueryElement.val(val);
};

Dk_Wildside_Display_Field.prototype.getName = function() {
	return this.name;
};

Dk_Wildside_Display_Field.prototype.getValue = function() {
	var value;
	if (this.jQueryElement.hasClass("GENTICS_editable")) {
		var id = this.jQueryElement.attr('id');
		value = GENTICS.Aloha.getEditableById(id).getContents();
	} else {
		value = this.jQueryElement.val();
	}
	this.value = value;
	return this.value;
};