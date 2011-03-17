

dk.wildside.display.field.Aloha = function(jQueryElement) {
	if (typeof jQueryElement == 'undefined') {
		return this;
	};
	dk.wildside.display.field.Field.call(this, jQueryElement);
	
	//console.info('Boostrapping Aloha field...');
	this.context.aloha().data('field', this).data('widget');
	this.config = jQuery.parseJSON(this.context.prevAll('.' + this.selectors.json).html());
	this.setSanitizer(dk.wildside.display.field.Sanitizer.trim);
	
	//dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.FieldEvent.CHANGE, this.jQueryElement);
	/*
	// Aloha bootstrapping.
	this.context.find(".aloha")
		.each(function(){
			// Instantiate Aloha on each object
			var obj = jQuery(this);
			obj.aloha();
		}).data("widget", this);
	 */
	
};

dk.wildside.display.field.Aloha.prototype = new dk.wildside.display.field.Field();


dk.wildside.display.field.Aloha.prototype.getName = function() {
	return this.config.name;
};