

dk.wildside.display.field.Select = function(jQueryElement) {
	
	dk.wildside.display.field.Field.call(this, jQueryElement);
	
	this.fieldContext = this.context.find(':input');
	
};

dk.wildside.display.field.Select.prototype = new dk.wildside.display.field.Field();