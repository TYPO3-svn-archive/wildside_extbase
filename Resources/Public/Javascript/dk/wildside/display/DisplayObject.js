/***************************************************************
* GUI Object - Base Class
* 
* Base class for GUI Objects. Contains standardized user interface 
* effects and feedback such as messaging, fades, HTML 
* manipulation the likes.
* 
***************************************************************/

Dk_Wildside_Display_DisplayObject = function(jQuerySelector) {
	this.context = false;
	this.payload = false;
	if (jQuerySelector != undefined) {
		this.setJQueryContext(jQuery(jQuerySelector));
	};
	Dk_Wildside_Event_EventDispatcher.apply(this);
};

Dk_Wildside_Display_DisplayObject.prototype = new Dk_Wildside_Event_EventDispatcher();

Dk_Wildside_Display_DisplayObject.prototype.setJQueryContext = function(context) {
	this.context = context;
	
	// Mark the jQuery element as having been registered
	context.addClass(Dk_Wildside_Util_Configuration.guiSelectors.inUse);
	
	// Read JSON-payload, if it exists
	var payloadElement = context.find("> ." + Dk_Wildside_Util_Configuration.guiSelectors.json);
	if (payloadElement.length) {
		var temppayload = payloadElement.text().trim();
		this.payload = (temppayload.length) ? jQuery.parseJSON(temppayload) : {};
	};
	
	// Store a "this"-reference on the object itself. That way, we can always access the
	// relevant JS data whenever we need it.
	context.data(Dk_Wildside_Util_Configuration.guiSelectors.jQueryDataName, this);
	
	// Store a classname which we can use to make hierachical lookups to find the first
	// parent. Basically, any sub-object triggering events can use this to report back to
	// the JS object we just stored.
	context.addClass(Dk_Wildside_Util_Configuration.guiSelectors.jsParent);
	
	// Return "this" for awesome chaining power.
	return this;
};


Dk_Wildside_Display_DisplayObject.prototype.getJQueryContext = function() {
	return this.context;
};

Dk_Wildside_Display_DisplayObject.prototype.fadeIn = function() {
	this.getJQueryContext().fadeIn();
	return this;
};

Dk_Wildside_Display_DisplayObject.prototype.fadeOut = function() {
	this.getJQueryContext().fadeOut();
	return this;
};

Dk_Wildside_Display_DisplayObject.prototype.replaceWith = function(source) {
	this.getJQueryContext().html(source);
	return this;
};

Dk_Wildside_Display_DisplayObject.prototype.remove = function() {
	this.replaceWith('');
	return this;
};

Dk_Wildside_Display_DisplayObject.prototype.expose = function() {
	console.info(this.context);
	//alert(this.payload.data.title);
};


