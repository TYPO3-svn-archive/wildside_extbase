/***************************************************************
* GUI Object - Base Class
* 
* Base class for GUI Objects. Contains standardized user interface 
* effects and feedback such as messaging, fades, HTML 
* manipulation the likes.
* 
***************************************************************/

dk.wildside.display.DisplayObject = function(jQuerySelector) {
	this.context = false;
	this.payload = false;
	if (jQuerySelector != undefined) {
		this.setJQueryContext(jQuery(jQuerySelector));
	};
	dk.wildside.event.EventDispatcher.apply(this, arguments);
};

dk.wildside.display.DisplayObject.prototype = new dk.wildside.event.EventDispatcher();

dk.wildside.display.DisplayObject.prototype.setJQueryContext = function(context) {
	this.context = context;
	
	// Mark the jQuery element as having been registered
	context.addClass(dk.wildside.util.Configuration.guiSelectors.inUse);
	
	// Read JSON-payload, if it exists
	var payloadElement = context.find("> ." + dk.wildside.util.Configuration.guiSelectors.json);
	if (payloadElement.length) {
		var temppayload = payloadElement.text().trim();
		this.payload = (temppayload.length) ? jQuery.parseJSON(temppayload) : {};
	};
	
	// Store a "this"-reference on the object itself. That way, we can always access the
	// relevant JS data whenever we need it.
	context.data(dk.wildside.util.Configuration.guiSelectors.jQueryDataName, this);
	
	// Store a classname which we can use to make hierachical lookups to find the first
	// parent. Basically, any sub-object triggering events can use this to report back to
	// the JS object we just stored.
	context.addClass(dk.wildside.util.Configuration.guiSelectors.jsParent);
	
	// Return "this" for awesome chaining power.
	return this;
};


dk.wildside.display.DisplayObject.prototype.getJQueryContext = function() {
	return this.context;
};

dk.wildside.display.DisplayObject.prototype.fadeIn = function() {
	this.getJQueryContext().fadeIn();
	return this;
};

dk.wildside.display.DisplayObject.prototype.fadeOut = function() {
	this.getJQueryContext().fadeOut();
	return this;
};

dk.wildside.display.DisplayObject.prototype.replaceWith = function(source) {
	this.getJQueryContext().html(source);
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


