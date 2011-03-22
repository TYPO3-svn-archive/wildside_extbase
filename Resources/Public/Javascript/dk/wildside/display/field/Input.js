

dk.wildside.display.field.Input = function(jQueryElement) {
	
	dk.wildside.display.field.Field.call(this, jQueryElement);
	
	this.addEventListener(dk.wildside.event.FieldEvent.BLUR, this.onChange);
	dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.FieldEvent.BLUR, this.fieldContext);
	
	this.setSanitizer( dk.wildside.display.field.Sanitizer[this.config.sanitizer] );
	
};

dk.wildside.display.field.Input.prototype = new dk.wildside.display.field.Field();

dk.wildside.display.field.Input.prototype.getValue = function() {
	return this.fieldContext.val();
};

dk.wildside.display.field.Input.prototype.setValue = function(val) {
	this.fieldContext.val(val);
	this.value = val;
};