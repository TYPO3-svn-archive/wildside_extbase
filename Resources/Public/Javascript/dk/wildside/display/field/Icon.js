

dk.wildside.display.field.Icon = function(jQueryElement) {
	
	dk.wildside.display.field.Field.call(this, jQueryElement);
	
	dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.MouseEvent.CLICK, this.jQueryElement);
	this.addEventListener(dk.wildside.event.MouseEvent.CLICK, this.onClick);
	
};

dk.wildside.display.field.Icon.prototype = new dk.wildside.display.field.Field();

dk.wildside.display.field.Icon.prototype.onClick = function(event) {
	this.trace('Icon clicked:');
	this.trace(event.currentTarget);
};