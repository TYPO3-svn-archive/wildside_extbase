

dk.wildside.display.field.Textarea = function(jQueryElement) {
	
	if (jQueryElement) {
		
		dk.wildside.display.field.Field.call(this, jQueryElement);
		
		dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.FieldEvent.BLUR, this.context);
		this.addEventListener.call(this, dk.wildside.event.FieldEvent.BLUR, this.onChange);
		
	};
};

dk.wildside.display.field.Textarea.prototype = new dk.wildside.display.field.Field();