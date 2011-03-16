

dk.wildside.display.field.Field = function(name, jQueryElement) {
	dk.wildside.display.DisplayObject.apply(this, arguments);
	try {
		this.name = name;
		this.jQueryElement = jQueryElement;
		this.value = this.getValue();
	}
	catch(e) {};
};

dk.wildside.display.field.Field.prototype = new dk.wildside.display.DisplayObject();

dk.wildside.display.field.Field.prototype.setValue = function(val) {
	this.value = val;
	this.jQueryElement.val(val);
};

dk.wildside.display.field.Field.prototype.getName = function() {
	return this.name;
};

dk.wildside.display.field.Field.prototype.getValue = function() {
	var value;
	if (this.jQueryElement.hasClass("GENTICS_editable")) {
		var id = this.jQueryElement.attr('id');
		value = GENTICS.Aloha.getEditableById(id).getContents();
	} else {
		value = this.jQueryElement.val();
	};
	this.value = value;
	return this.value;
};