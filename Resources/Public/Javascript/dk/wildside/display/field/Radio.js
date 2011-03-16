

dk.wildside.display.field.Radio = function() {
	
	dk.wildside.display.field.Field.apply(this, arguments);
	
	this.addEventListener(dk.wildside.event.MouseEvent.CLICK, this.onChange);
	dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.MouseEvent.CLICK, this.jQueryElement);
	
};

dk.wildside.display.field.Radio.prototype = new dk.wildside.display.field.Field();

dk.wildside.display.field.Radio.prototype.getValue = function() {
	return this.jQueryElement.parents("." + dk.wildside.util.Configuration.guiSelectors.widget + ":first").find("*[name='"+ this.name +"']:checked").attr("value");
};