

dk.wildside.display.field.Checkbox = function(jQueryElement) {
	dk.wildside.display.field.Field.call(this, jQueryElement);
	//this.trace(this.context);
	this.fieldContext = this.context.find(':input');
	this.fieldContext.data('field', this);
	//this.trace(this.fieldContext);
	dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.MouseEvent.CLICK, this.fieldContext);
	this.addEventListener.call(this, dk.wildside.event.MouseEvent.CLICK, this.onChange);
};

dk.wildside.display.field.Checkbox.prototype = new dk.wildside.display.field.Field();

dk.wildside.display.field.Checkbox.prototype.getValue = function() {
	return this.fieldContext.is(':checked') ? 1 : 0;
};