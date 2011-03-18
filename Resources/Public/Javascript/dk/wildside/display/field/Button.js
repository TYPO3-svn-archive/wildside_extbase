
dk.wildside.display.field.Button = function(jQueryElement) {

	dk.wildside.display.field.Field.call(this, jQueryElement);
		
	this.fieldContext = this.context.find(':input');
	this.fieldContext.data('field', this);
		
	dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.MouseEvent.CLICK, this.fieldContext, this);
	
};

dk.wildside.display.field.Button.prototype = new dk.wildside.display.field.Field();

dk.wildside.display.field.Button.prototype.onClick = function() {};