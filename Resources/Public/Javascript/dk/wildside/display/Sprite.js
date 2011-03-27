dk.wildside.display.Sprite = function(jQueryElement) {
	if (typeof jQueryElement == 'undefined') {
		return this;
	} else if (typeof jQueryElement == 'string') {
		// DIFFERENCE here between other DisplayObjects and Sprites:
		// Sprites create their own jQueryContext (which starts out empty)
		// and wraps the html() method to allow adding HTML
		var jQueryContext = jQuery(jQueryElement);
		return new dk.wildside.display.Sprite(jQueryContext);
	};
	dk.wildside.display.DisplayObject.call(this, jQueryElement);
	this.captureJQueryEvents(jQueryElement);
	this.identity = 'sprite';
};

dk.wildside.display.Sprite.prototype = new dk.wildside.display.DisplayObject();

dk.wildside.display.Sprite.prototype.html = function(str) {
	return this.context.html(str);
};