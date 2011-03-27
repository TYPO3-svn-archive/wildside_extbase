

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

dk.wildside.event.EventDispatcher.prototype.hasEventListener = function(eventType, func) {
	if (typeof scope == 'undefined') {
		scope = this;
	};
	this.initializeIfMissing(eventType);
	return this.listeners[eventType].contains(func);
};

dk.wildside.event.EventDispatcher.prototype.addEventListener = function(eventType, func) {
	if (typeof eventType == 'undefined') {
		this.trace('Invalid event type: ' + eventType);
	};
	if (typeof scope == 'undefined') {
		scope = this;
	};
	this.initializeIfMissing(eventType);
	this.listeners[eventType].push(func);
	return this;
};

dk.wildside.event.EventDispatcher.prototype.removeEventListener = function(eventType, func) {
	if (typeof scope == 'undefined') {
		scope = this;
	};
	if (typeof func == 'undefined') {
		this.listeners[eventType] = new dk.wildside.util.Iterator();
	} else {
		this.initializeIfMissing(eventType);
		this.listeners[eventType] = this.listeners[eventType].remove(func);
	};
	return this;
};

dk.wildside.event.EventDispatcher.prototype.dispatchEvent = function(event) {
	//console.log(event);
	if (typeof event == 'string') {
		var eventType = event;
		event = {
			type: eventType, 
			target: this,
			cancelled: false, 
			id: Math.round(Math.random()*100000)
		};
	} else if (event.view) {
		// is a jQuery event - transform to native event and attach originalEvent
		var instance = jQuery(event.currentTarget).data('instance');
		var original = event;
		event = {
			type: event.type, 
			target: instance,
			cancelled: false, 
			id: Math.round(Math.random()*100000),
			originalEvent : original
		};
		return instance.dispatchEvent.call(instance, event);
	};
	event.currentTarget = this;
	//console.info('Dispatching event: '+event.type+' with ID ' + event.id + '. My identity: ' + this.identity);
	if (typeof this.listeners[event.type] != 'undefined') {
		this.listeners[event.type].each(function(func) {
			func.call(event.currentTarget, event);
		});
	};
	var parent = this.getParent();
	if (parent && event.cancelled == false) {
		parent.dispatchEvent.call(parent, event);
	} else {
		delete(event); // reached top level, remove all traces of event
	};
	return this;
};

dk.wildside.event.EventDispatcher.prototype.captureJQueryEvents = function(context, parent) {
	if (typeof context == 'undefined') {
		context = this;
	};
	if (typeof parent == 'undefined') {
		parent = this;
	};
	var events = new dk.wildside.util.Iterator();
	events.merge(['change', 'click', 'keydown', 'keyup', 'keypress', 'focus', 'blur',
	              'mouseover', 'mousemove', 'mouseenter', 'mouseleave', 'mouseup', 
	              'mousedown', 'resize', 'select', 'scroll', 'submit']);
	events.each(function(eventType) {
		context.data('instance', parent).live(eventType, parent.dispatchEvent);
	});
};
