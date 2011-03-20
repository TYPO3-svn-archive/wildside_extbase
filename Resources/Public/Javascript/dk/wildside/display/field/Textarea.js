

dk.wildside.display.field.Textarea = function(jQueryElement) {
	if (jQueryElement) {
		dk.wildside.display.field.Field.call(this, jQueryElement);
		this.fieldContext = this.context.find('textarea');
		dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.FieldEvent.BLUR, this.fieldContext);
		this.addEventListener(dk.wildside.event.FieldEvent.BLUR, this.onChange);
	};
};

dk.wildside.display.field.Textarea.prototype = new dk.wildside.display.field.Field();

dk.wildside.display.field.Textarea.prototype.getValue = function() {
	return this.fieldContext.val();
};