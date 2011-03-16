

dk.wildside.display.field.Field = function(name, jQueryElement) {
	dk.wildside.display.DisplayObject.apply(this, arguments);
	try {
		this.events = dk.wildside.event.FieldEvent;
		this.name = name;
		this.dirty = false;
		this.jQueryElement = jQueryElement;
		this.value = this.getValue();
		jQueryElement.addClass("herpderp");
		jQueryElement.data(dk.wildside.util.Configuration.guiSelectors.jQueryDataName, this);
		this.sanitizer = dk.wildside.display.field.Sanitizer.noop;
		this.addEventListener(dk.wildside.event.FieldEvent.CHANGE, this.onChange);
	} catch(e) {
		console.log(e);
	};
};

dk.wildside.display.field.Field.prototype = new dk.wildside.display.DisplayObject();

dk.wildside.display.field.Field.prototype.setSanitizer = function(san) {
	if (typeof san == 'function') {
		this.sanitizer = san;
	};
};

dk.wildside.display.field.Field.prototype.onChange = function() {
	var value = this.getValue();
	value = this.sanitizer(value);
	this.setValue(value);
};

dk.wildside.display.field.Field.prototype.setValue = function(val) {
	var oldValue = this.getValue();
	this.value = val;
	this.jQueryElement.val(val);
	if (this.value != oldValue) {
		this.dirty = true;
		this.dispatchEvent(dk.wildside.event.Event.DIRTY);
	};
};

dk.wildside.display.field.Field.prototype.setClean = function() {
	this.dirty = false;
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