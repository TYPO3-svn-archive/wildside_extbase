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
	};
	dk.wildside.event.EventDispatcher.call(this, jQueryElement);
	this.context = jQueryElement;
	this.config = jQueryElement.data('config');
	this.selectors = dk.wildside.util.Configuration.guiSelectors;
	this.context.data('instance', this); // back-reference
	this.context.addClass(this.selectors.inUse); // claim DOM element
	this.children = new dk.wildside.util.Iterator();
	// defaults for visual effects:
	this.visuals = {
		duration : 750
	};
	return this;
};

dk.wildside.display.DisplayObject.prototype = new dk.wildside.event.EventDispatcher();

dk.wildside.display.DisplayObject.prototype.fadeIn = function(duration) {
	if (typeof duration == 'undefined') {
		duration = this.visuals.duration;
	};
	this.context.fadeIn(duration);
	return this;
};

dk.wildside.display.DisplayObject.prototype.fadeOut = function(duration) {
	if (typeof duration == 'undefined') {
		duration = this.visuals.duration;
	};
	this.context.fadeOut(duration);
	return this;
};

dk.wildside.display.DisplayObject.prototype.show = function() {
	this.context.show();
	return this;
};

dk.wildside.display.DisplayObject.prototype.hide = function() {
	this.context.hide();
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

dk.wildside.display.DisplayObject.prototype.copy = function() {
	var newContext = this.context.clone();
	var newItem = new this(newContext);
	return newItem;
};

dk.wildside.display.DisplayObject.prototype.addChild = function(displayObject, addHtml) {
	this.children.push(displayObject);
	displayObject.setParent(this);
	if (addHtml) {
		this.context.append(displayObject.context.html());
	};
};

dk.wildside.display.DisplayObject.prototype.expose = function() {
	this.trace(this.context, 'info');
};

dk.wildside.display.DisplayObject.prototype.trace = function(victim, method) {
	if (typeof console != 'undefined' && dk.wildside.util.Configuration.traceEnabled == true) {
		if (typeof method == 'undefined') {
			method = 'info';
		};
		if (method == 'warn') {
			var func = console[method];
			func.call(console, victim);
		};
	};
};

