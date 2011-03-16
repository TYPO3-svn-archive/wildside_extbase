
dk.wildside.display.field.Button = function(name, jQueryElement, widget) {
	dk.wildside.display.field.Field.apply(this, arguments);
	console.log(widget.update);
	this.addEventListener(dk.wildside.event.MouseEvent.CLICK, widget.update);
};

dk.wildside.display.field.Button.prototype = new dk.wildside.display.field.Field();