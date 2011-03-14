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

dk.wildside.display.Component = function() {
	
	dk.wildside.display.DisplayObject.apply(this, arguments);
	
	this.CONST_LOADING_EAGER = 0;
	this.CONST_LOADING_LAZY = 1;
	
	this.loadingStrategy = false;
	this.widgets = new dk.wildside.util.Iterator();
	this.uniqueID = Math.round(Math.random() * 100000);
	this.setLoadingStrategy(this.CONST_LOADING_EAGER);
};

dk.wildside.display.Component.prototype = new dk.wildside.display.DisplayObject();

dk.wildside.display.Component.prototype.setLoadingStrategy = function(strategy) {
	this.loadingStrategy = strategy;
};


dk.wildside.display.Component.prototype.getDirtyWidgets = function() {
	return this.widgets.filter(function(widget) { return widget.getDirty(); });
};

dk.wildside.display.Component.prototype.cleanDirtyWidgets = function() {
	this.getDirtyWidgets().each(function(widget) { return widget.setClean(); });
	this.dirtyWidgets = [];
	return this;
};

dk.wildside.display.Component.prototype.registerWidget = function(widget) {
	this.widgets.push(widget);
	return this;
};


dk.wildside.display.Component.prototype.update = function(forceUpdate) {
	// Only run the update if the loading strategy is "eager", or if we're forcing
	// the widgets to update (in case of lazy loading).
	if ((this.loadingStrategy == this.CONST_LOADING_EAGER) || forceUpdate) {
		this.getDirtyWidgets().each(function(widget) { widget.sync(); });
	};
	
};