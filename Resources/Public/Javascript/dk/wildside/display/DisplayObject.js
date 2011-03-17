/***************************************************************
* GUI Object - Base Class
* 
* Base class for GUI Objects. Contains standardized user interface 
* effects and feedback such as messaging, fades, HTML 
* manipulation the likes.
* 
***************************************************************/

dk.wildside.display.DisplayObject = function(jQueryElement) {
	if (typeof jQueryElement == 'undefined') {
		return this;
	} else {
		jQueryElement = jQuery(jQueryElement);
	};
	dk.wildside.event.EventDispatcher.call(this, jQueryElement);
	this.selectors = dk.wildside.util.Configuration.guiSelectors;
	this.context = jQueryElement;
	this.context.data(this.selectors.jQueryDataName, this); // back-reference
	this.config = jQuery.parseJSON(jQueryElement.find('.' + this.selectors.json).html());
	this.context.addClass(this.selectors.inUse); // claim DOM element
	
	// Read JSON-payload, if it exists
	var payloadElement = this.context.find("> ." + this.selectors.json);
	if (payloadElement.length) {
		var temppayload = payloadElement.text().trim();
		this.payload = (temppayload.length) ? jQuery.parseJSON(temppayload) : {};
	};
	
	// TODO: evaluate. Is this still true after EventListener implementation?
	// TODO: if no longer necessary, remove from guiSelectors config too.
	// Store a classname which we can use to make hierachical lookups to find the first
	// parent. Basically, any sub-object triggering events can use this to report back to
	// the JS object we just stored.
	this.context.addClass(this.selectors.jsParent);
	return this;
};

dk.wildside.display.DisplayObject.prototype = new dk.wildside.event.EventDispatcher();

dk.wildside.display.DisplayObject.prototype.fadeIn = function() {
	this.getJQueryContext().fadeIn();
	return this;
};

dk.wildside.display.DisplayObject.prototype.fadeOut = function() {
	this.getJQueryContext().fadeOut();
	return this;
};

dk.wildside.display.DisplayObject.prototype.replaceWith = function(source) {
	this.context.html(source);
	return this;
};

dk.wildside.display.DisplayObject.prototype.remove = function() {
	this.replaceWith('');
	return this;
};

dk.wildside.display.DisplayObject.prototype.expose = function() {
	console.info(this.context);
	//alert(this.payload.data.title);
};


