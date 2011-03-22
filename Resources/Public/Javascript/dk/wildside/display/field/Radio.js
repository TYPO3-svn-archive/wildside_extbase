

dk.wildside.display.field.Radio = function() {
	
	dk.wildside.display.field.Field.apply(this, arguments);
	
	dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.MouseEvent.CLICK, this.fieldContext);
	
	this.addEventListener(dk.wildside.event.MouseEvent.CLICK, this.onChange);
	
};

dk.wildside.display.field.Radio.prototype = new dk.wildside.display.field.Field();

dk.wildside.display.field.Radio.prototype.getValue = function() {
	var value = this.fieldContext.parents("." + this.selectors.field + ":first").find(":checked").attr("value");
	return value;
};