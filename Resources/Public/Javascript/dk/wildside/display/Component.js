/***************************************************************
* Component - Base Class
* 
* Base class for components. A component can contain any number 
* of widgets, is able to iterate these widgets and collect data 
* or issue GUI updates.
* 
* Components generate Requests with payload data and use the 
* Dispatcher to send the Request to the server. The server then 
* determines the correct Responder procedure - the default 
* behavior is to store a reference to the caller (the component 
* instance) and send the response data to the caller.
* 
***************************************************************/

dk.wildside.display.Component = function(jQueryElement) {
	if (typeof jQueryElement == 'undefined') {
		return this;
	};
	dk.wildside.display.DisplayObject.call(this, jQueryElement);
	this.CONST_LOADING_EAGER = 0;
	this.CONST_LOADING_LAZY = 1;
	this.loadingStrategy = false;
	this.dirtyWidgets = new dk.wildside.util.Iterator();
	this.uniqueID = Math.round(Math.random() * 100000);
	this.setLoadingStrategy(this.CONST_LOADING_EAGER);
	
	var json = jQuery.parseJSON(this.context.find("> ." + this.selectors.json).text().trim());
	var componentType = json.component;
	eval("if (typeof(" + componentType + ") == 'function') " + componentType + ".call(this);");
	this.trace(componentType + ' component detected.');
	
	// Find all immediate widgets anywhere in the subtree, but NOT if they're preceded by a new component section.
	// We only want children of this specific component, wherever they may be. Or roam. That's a Metallica song, btw.
	var parent = this;
	this.context.find("." + this.selectors.widget +":not(." + this.selectors.inUse +")").not(this.context.find("." + this.selectors.component +" ." + this.selectors.widget)).each( function() {
		var widget = new dk.wildside.display.widget.Widget(this);
		parent.registerWidget(widget);
	});
	
	return this;
};

dk.wildside.display.Component.prototype = new dk.wildside.display.DisplayObject;

dk.wildside.display.Component.prototype.setLoadingStrategy = function(strategy) {
	this.loadingStrategy = strategy;
};

dk.wildside.display.Component.prototype.onDirtyWidget = function(widgetEvent) {
	//console.info('Component caught dirty widget event');
	if (this.dirtyWidgets.contains(widgetEvent.currentTarget) == false) {
		this.dirtyWidgets.push(widgetEvent.currentTarget);
	};
	if (this.loadingStrategy == this.CONST_LOADING_EAGER) {
		// If "lazy", the Component relies on other means to call sync().
		this.sync();
	};
};

dk.wildside.display.Component.prototype.onCleanWidget = function(widgetEvent) {
	this.dirtyWidgets.remove(widgetEvent.currentTarget);
};

dk.wildside.display.Component.prototype.registerWidget = function(widget) {
	widget.addEventListener(dk.wildside.event.widget.WidgetEvent.DIRTY, this.onDirtyWidget, this);
	widget.addEventListener(dk.wildside.event.widget.WidgetEvent.CLEAN, this.onCleanWidget, this);
	widget.registerComponent(this);
	widget.setParent(this);
	return this;
};

dk.wildside.display.Component.prototype.sync = function() {
	this.dirtyWidgets.each(function(widget) { widget.sync(); });
};
