

dk.wildside.display.field.Field = function(jQueryElement) {
	if (typeof jQueryElement == 'undefined') {
		return this;
	};
	dk.wildside.display.DisplayObject.call(this, jQueryElement);
	try {
		this.__field = this;
		this.events = dk.wildside.event.FieldEvent;
		this.dirty = false;
		this.value = this.getValue();
		this.context.data(this.selectors.jQueryDataName, this);
		this.sanitizer = dk.wildside.display.field.Sanitizer.noop;
		this.addEventListener(dk.wildside.event.FieldEvent.CHANGE, this.onChange);
	} catch(e) {
		//console.error(e);
		//console.log(this.context);
		//console.warn("Error from field.Field:");
		//console.warn(e);
	};
	return this;
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
	var oldValue = this.value;
	this.value = val;
	//this.context.val(val);
	//if (this.value != oldValue) {
		this.dirty = true;
		this.dispatchEvent(dk.wildside.event.Event.DIRTY);
	//};
	//console.info(this.value != oldValue);
	//console.log(this.value.toString() + ' == ' + oldValue.toString());
	return this;
};

dk.wildside.display.field.Field.prototype.setClean = function() {
	this.dirty = false;
};

dk.wildside.display.field.Field.prototype.getName = function() {
	return this.context.attr('name');
};

dk.wildside.display.field.Field.prototype.getValue = function() {
	var value;
	if (this.context.hasClass("GENTICS_editable")) {
		var id = this.context.attr('id');
		value = GENTICS.Aloha.getEditableById(id).getContents();
	} else {
		value = this.context.val();
	};
	//this.value = value;
	return value;
};