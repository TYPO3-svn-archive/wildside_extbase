
dk.wildside.display.field.Button = function(name, jQueryElement, widget) {
	
	this.addEventListener(dk.wildside.event.MouseEvent.CLICK, widget.sync);
	dk.wildside.display.field.Field.apply(this, arguments);
};

dk.wildside.display.field.Button.prototype = new dk.wildside.display.field.Field();