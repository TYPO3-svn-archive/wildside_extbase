

dk.wildside.event.EventDispatcher = function() {
	this.listeners = {};
};

dk.wildside.event.EventDispatcher.prototype.initializeIfMissing = function(eventType) {
	if (typeof this.listeners[eventType] == 'undefined') {
		this.listeners[eventType] = new dk.wildside.util.Iterator();
	};
};

dk.wildside.event.EventDispatcher.prototype.hasEventListener = function(eventType, func) {
	this.initializeIfMissing(eventType);
	return this.listeners[eventType].contains(func);
};

dk.wildside.event.EventDispatcher.prototype.addEventListener = function(eventType, func) {
	this.initializeIfMissing(eventType);
	this.listeners[eventType].push(func); 
};

dk.wildside.event.EventDispatcher.prototype.removeEventListener = function(eventType, func) {
	this.initializeIfMissing(eventType);
	this.listeners[eventType] = this.listeners[eventType].remove(func);
};

dk.wildside.event.EventDispatcher.prototype.dispatchEvent = function(eventType, eventData) {
	console.info("Event '" + eventType + "' fired");
	this.initializeIfMissing(eventType);
	var localScope = this;
	return this.listeners[eventType].each(function(func) { func.call(localScope, this, eventData); });
};