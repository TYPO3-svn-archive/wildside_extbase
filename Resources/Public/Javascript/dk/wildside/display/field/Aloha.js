

dk.wildside.display.field.Aloha = function(jQueryElement) {
	if (typeof jQueryElement == 'undefined') {
		return this;
	};
	dk.wildside.display.field.Field.call(this, jQueryElement);
	this.alohaContext = this.context.find('.aloha').aloha();
	this.alohaContext.data('field', this);
	this.setSanitizer(dk.wildside.display.field.Sanitizer.trim);
};

dk.wildside.display.field.Aloha.prototype = new dk.wildside.display.field.Field();


dk.wildside.display.field.Aloha.prototype.getName = function() {
	return this.config.name;
};

dk.wildside.display.field.Aloha.prototype.getValue = function() {
	var id = this.alohaContext.attr('id');
	value = GENTICS.Aloha.getEditableById(id).getContents();
	return value;
};
