

dk.wildside.event.EventDispatcher = function(jQueryElement) {
	if (typeof jQueryElement == 'undefined') {
		return this;
	};
	this.listeners = {};
	this.parent = false;
};

dk.wildside.event.EventDispatcher.prototype.setParent = function(parent) {
	this.parent = parent;
};

dk.wildside.event.EventDispatcher.prototype.getParent = function() {
	return this.parent;
};

dk.wildside.event.EventDispatcher.prototype.initializeIfMissing = function(eventType) {
	try {
		if (typeof this.listeners[eventType] == 'undefined') {
			this.listeners[eventType] = new dk.wildside.util.Iterator();
		};
	} catch (e) {
		//console.log(eventType);
		//console.log(this);
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
		//console.info('Invalid event type: ' + eventType);
		//console.log(this);
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

dk.wildside.event.EventDispatcher.prototype.dispatchEvent = function(eventType, target, originalEvent) {
	var event;
	if (typeof target == 'undefined') {
		target = this;
	};
	if (typeof eventType == 'object') {
		event = eventType;
		eventType = event.type;
	} else {
		event = {type: eventType, target: target, cancelled: false};
	};
	event.currentTarget = this;
	if (typeof this.listeners[eventType] != 'undefined') {
		//console.log('Dispatching event: '+eventType);
		this.listeners[eventType].each(function(info) {
			//console.log(info);
			var scope = info[0];
			var func = info[1];
			//console.log(info);
			//console.info('Calling function...');
			func.call(scope, event);
		});
	};
	var parent = this.getParent();
	if (parent && event.cancelled == false) {
		parent.dispatchEvent.call(parent, event, target, originalEvent);
	};
	return this;
};