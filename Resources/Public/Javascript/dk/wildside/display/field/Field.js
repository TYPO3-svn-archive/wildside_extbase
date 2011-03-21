

dk.wildside.display.field.Field = function(jQueryElement) {
	if (typeof jQueryElement == 'undefined') {
		return this;
	};
	dk.wildside.display.DisplayObject.call(this, jQueryElement);
	try {
		//this.dirty = false;
		if (typeof this.identity == 'undefined') {
			this.identity = 'field';
		};
		this.sanitizer = dk.wildside.display.field.Sanitizer.noop;
		this.events = dk.wildside.event.FieldEvent;
		this.fieldContext = this.context.find(':input').data('field', this);
		//this.config = jQuery.parseJSON(this.context.find('> .' + this.selectors.json + ':first').html());
		//this.value = this.config.value;
	} catch(e) {
		this.trace("Error from field.Field:", 'warn');
		this.trace(e, 'warn');
	};
	return this;
};

dk.wildside.display.field.Field.prototype = new dk.wildside.display.DisplayObject();

dk.wildside.display.field.Field.prototype.getFieldContext = function() {
	if (this.fieldContext) {
		return this.fieldContext;
	} else {
		return this.context;
	};
};

dk.wildside.display.field.Field.prototype.setSanitizer = function(san) {
	if (typeof san == 'function') {
		this.sanitizer = san;
	};
};

dk.wildside.display.field.Field.prototype.onChange = function(event) {
	event.cancelled = true; // may need to remove this if we want to listen for jQuery-type events in Components/Widgets
	var value = this.getValue();
	value = this.sanitizer(value);
	this.dispatchEvent(dk.wildside.event.FieldEvent.DIRTY);
	this.setValue(value);
};

dk.wildside.display.field.Field.prototype.setValue = function(val) {
	this.value = val;
};

dk.wildside.display.field.Field.prototype.setClean = function() {
	this.dirty = false;
};

dk.wildside.display.field.Field.prototype.getName = function() {
	return this.config.name;
};

dk.wildside.display.field.Field.prototype.getValue = function() {
	return this.context.val();
};