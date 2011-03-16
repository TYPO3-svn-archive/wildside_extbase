

dk.wildside.event.EventDispatcher = function(jQueryElement) {
	if (typeof jQueryElement == 'undefined') {
		return this;
	};
	this.listeners = {};
};

dk.wildside.event.EventDispatcher.prototype.initializeIfMissing = function(eventType) {
	if (typeof this.listeners[eventType] == 'undefined') {
		this.listeners[eventType] = new dk.wildside.util.Iterator();
	};
};

dk.wildside.event.EventDispatcher.prototype.hasEventListener = function(eventType, func, scope) {
	if (typeof scope == 'undefined') {
		scope = this;
	};
	this.initializeIfMissing(eventType);
	return this.listeners[eventType].contains([scope, func]);
};

dk.wildside.event.EventDispatcher.prototype.addEventListener = function(eventType, func, scope) {
	if (typeof eventType == 'undefined') {
		console.info('Invalid event type: ' + eventType);
		console.log(this);
	};
	if (typeof scope == 'undefined') {
		scope = this;
	};
	this.initializeIfMissing(eventType);
	this.listeners[eventType].push([scope, func]);
	return this;
};

dk.wildside.event.EventDispatcher.prototype.removeEventListener = function(eventType, func, scope) {
	if (typeof scope == 'undefined') {
		scope = this;
	};
	this.initializeIfMissing(eventType);
	this.listeners[eventType] = this.listeners[eventType].remove([scope, func]);
	return this;
};

dk.wildside.event.EventDispatcher.prototype.dispatchEvent = function(eventType, target) {
	if (typeof this.listeners[eventType] == 'undefined') {
		return this;
	};
	if (typeof target == 'undefined') {
		target = this;
	};
	var event = {type: eventType, target: target};
	this.listeners[eventType].each(function(info) {
		//console.log(info);
		info[1].call(info[0], event);
	});
	return this;
};