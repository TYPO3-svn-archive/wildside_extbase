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
	// loading strategies - set in ComponentViewHelper or override in subclass
	this.CONST_LOADING_EAGER = 'eager';
	this.CONST_LOADING_LAZY = 'lazy';
	if (typeof this.identity == 'undefined') {
		this.identity = 'component';
	};
	this.widgets = new dk.wildside.util.Iterator();
	this.dirtyWidgets = new dk.wildside.util.Iterator();
	this.loadingStrategy = this.config.strategy;
	
	// Widget detection, only detect Widgets which are not members of Component below this Component
	var parent = this; // necessary reference for the following jQuery enclosure
	this.context.find("." + this.selectors.widget +":not(." + this.selectors.inUse +")").not(this.context.find("." + this.selectors.component +" ." + this.selectors.widget)).each( function() {
		var widget = dk.wildside.spawner.get(this);
		parent.registerWidget(widget);
	});
	
	this.addEventListener(dk.wildside.event.widget.WidgetEvent.DIRTY, this.onDirtyWidget);
	this.addEventListener(dk.wildside.event.widget.WidgetEvent.CLEAN, this.onCleanWidget);
	this.addEventListener(dk.wildside.event.widget.WidgetEvent.REFRESH, this.onRefreshWidget);
	
	return this;
};

dk.wildside.display.Component.prototype = new dk.wildside.display.DisplayObject;

dk.wildside.display.Component.prototype.setLoadingStrategy = function(strategy) {
	this.loadingStrategy = strategy;
};

dk.wildside.display.Component.prototype.refreshFamiliarWidgets = function(sourceWidget) {
	this.widgets.each(function(widget) {
		if (widget.getConfiguration().data.uid == uid && sourceWidget != widget) {
			widget.dispatchEvent(dk.wildside.event.widget.WidgetEvent.REFRESH);
		};
	});
};

dk.wildside.display.Component.prototype.onDirtyWidget = function(widgetEvent) {
	if (this.dirtyWidgets.contains(widgetEvent.target) == false) {
		this.dirtyWidgets.push(widgetEvent.target);
	};
	if (this.loadingStrategy == this.CONST_LOADING_EAGER) {
		var issuer = this;
		setTimeout(function() {
			issuer.sync.call(issuer);
		}, 10);
	};
};

dk.wildside.display.Component.prototype.onCleanWidget = function(widgetEvent) {
	this.dirtyWidgets = this.dirtyWidgets.removeByContext(widgetEvent.target);
};

dk.wildside.display.Component.prototype.registerWidget = function(widget) {
	widget.registerComponent(this);
	widget.setParent(this);
	this.widgets.push(widget);
	return this;
};

dk.wildside.display.Component.prototype.sync = function() {
	this.dirtyWidgets.each(function(widget) { widget.sync(); });
};

dk.wildside.display.Component.prototype.rollback = function() {
	this.widgets.each(function(widget) { widget.rollback(); });
};
