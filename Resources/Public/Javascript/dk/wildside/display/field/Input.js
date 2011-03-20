

dk.wildside.display.field.Input = function(jQueryElement) {
	
	dk.wildside.display.field.Field.call(this, jQueryElement);
	
	dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.FieldEvent.CHANGE, this.fieldContext);
	
};

dk.wildside.display.field.Input.prototype = new dk.wildside.display.field.Field();