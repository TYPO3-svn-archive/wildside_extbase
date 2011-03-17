

dk.wildside.display.field.Checkbox = function(jQueryElement) {
	
	if (jQueryElement) {
		
		dk.wildside.display.field.Field.call(this, jQueryElement);
		dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.MouseEvent.CLICK, this.context);
		this.addEventListener.call(this, dk.wildside.event.MouseEvent.CLICK, this.onChange);
		
	};
	
};

dk.wildside.display.field.Checkbox.prototype = new dk.wildside.display.field.Field();