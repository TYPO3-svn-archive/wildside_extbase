

dk.wildside.display.field.Radio = function() {
	
	dk.wildside.display.field.Field.apply(this, arguments);
	
	this.jQueryElement.change( this.setDirty );
	
};

dk.wildside.display.field.Radio.prototype = new dk.wildside.display.field.Field();

dk.wildside.display.field.Radio.prototype.getValues = function() {
	return this.parents(dk.wildside.util.Configuration.guiSelectors.widget + ":first").find(":checkbox[name='"+ this.name +"']:checked").attr("value");
};