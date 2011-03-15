

dk.wildside.display.Field = function(name, jQueryElement) {
	dk.wildside.display.DisplayObject.apply(this, arguments);
	this.name = name;
	this.jQueryElement = jQueryElement;
	this.value = this.getValue();
};

dk.wildside.display.Field.prototype = new dk.wildside.display.DisplayObject();

dk.wildside.display.Field.prototype.setValue = function(val) {
	this.value = val;
	this.jQueryElement.val(val);
};

dk.wildside.display.Field.prototype.getName = function() {
	return this.name;
};

dk.wildside.display.Field.prototype.getValue = function() {
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