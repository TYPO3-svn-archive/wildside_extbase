

dk.wildside.display.field.Input = function() {
	
	dk.wildside.display.field.Field.apply(this, arguments);
	
	dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.FieldEvent.CHANGE, this.jQueryElement);
	
};

dk.wildside.display.field.Input.prototype = new dk.wildside.display.field.Field();