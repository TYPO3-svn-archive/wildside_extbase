

dk.wildside.display.field.Radio = function() {
	
	dk.wildside.display.field.Field.apply(this, arguments);
	
	dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.MouseEvent.CLICK, this.context);
	
	this.addEventListener(dk.wildside.event.MouseEvent.CLICK, this.onChange);
	
};

dk.wildside.display.field.Radio.prototype = new dk.wildside.display.field.Field();

dk.wildside.display.field.Radio.prototype.getValue = function() {
	return this.context.parents("." + dk.wildside.util.Configuration.guiSelectors.widget + ":first").find("*[name='"+ this.name +"']:checked").attr("value");
};