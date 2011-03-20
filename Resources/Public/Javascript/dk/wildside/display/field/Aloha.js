

dk.wildside.display.field.Aloha = function(jQueryElement) {
	if (typeof jQueryElement == 'undefined') {
		return this;
	};
	dk.wildside.display.field.Field.call(this, jQueryElement);
	this.fieldContext = this.context.find('.aloha').aloha();
	this.fieldContext.data('field', this);
	this.setSanitizer(dk.wildside.display.field.Sanitizer.trim);
	this.onTimer(); // initialize dirty-check timer
	this.lastValue = this.getValue();
	this.active = false;
};

dk.wildside.display.field.Aloha.prototype = new dk.wildside.display.field.Field();


dk.wildside.display.field.Aloha.prototype.getName = function() {
	return this.config.name;
};

dk.wildside.display.field.Aloha.prototype.getValue = function() {
	var id = this.fieldContext.attr('id');
	value = GENTICS.Aloha.getEditableById(id).getContents();
	return value;
};

dk.wildside.display.field.Aloha.prototype.onTimer = function() {
	var issuer = this;
	var oldValue = this.lastValue;
	var value = this.getValue();
	if (oldValue != value && this.active == false) {
		this.dispatchEvent(dk.wildside.event.FieldEvent.DIRTY);
		this.lastValue = value;
	};
	this.timer = setTimeout(function() {
		issuer.onTimer.call(issuer);
	}, 5000);
};