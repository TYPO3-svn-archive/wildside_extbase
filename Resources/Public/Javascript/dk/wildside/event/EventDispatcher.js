

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
	var instance = this;
	var newID = Math.round(Math.random()*100000);
	
	if (typeof event == 'string') {
		var eventType = event;
		event = {
			type: eventType, 
			target: instance,
			cancelled: false, 
			id: newID
		};
	} else if (event.handleObj) {
		// is a jQuery event - transform to native event and attach originalEvent
		instance = jQuery(this).data('instance');
		var original = event;
		event = {
			type: event.type, 
			target: instance,
			currentTarget: instance,
			cancelled: false, 
			id: newID,
			originalEvent : original
		};
		
		//alert('Dispatching event: '+event.type+' with ID ' + event.id + ' ('+newID+'). My identity: ' + instance.identity);
		//alert('migrating from jQuery event to WS event');
		return instance.dispatchEvent.call(instance, event);
	};
	if (typeof instance.listeners == 'undefined') {
		instance = jQuery(instance).data('instance');
	};
	//console.info('Dispatching event: '+event.type+' with ID ' + event.id + '. My identity: ' + instance.identity);
	//if (event.type == 'click') jQuery("body:first").append('<div>Dispatching event: '+event.type+' with ID ' + event.id + ' ('+newID+'). My identity: ' + instance.identity+'</div>');
	
	event.currentTarget = instance;
	if (typeof instance.listeners[event.type] != 'undefined') {
		instance.listeners[event.type].each(function(func) {
			func.call(event.currentTarget, event);
		});
	};
	var parent = instance.getParent();
	if (parent && event.cancelled == false) {
		
		//if (event.type == 'click') jQuery("body:first").append(typeof(parent));
		
		//console.info('Going up... ' + event.type + ' from ' + instance.identity + ' to ' + parent.identity);
		parent.dispatchEvent.call(parent, event);
	} else {
		
		//if (event.type == 'click') jQuery("body:first").append("Killed event - no parent");
		
		//alert(typeof instance.children);
		//alert(instance.children.length);
		//alert('Parent does not exist. I am a ' + instance.identity);
		//console.warn(instance);
		delete(event); // reached top level, remove all traces of event
	};
	return instance;
};

dk.wildside.event.EventDispatcher.prototype.captureJQueryEvents = function(onlyEvents, context, parent) {
	if (typeof context == 'undefined') {
		context = this.context;
	};
	if (typeof parent == 'undefined') {
		parent = this;
	};
	var events = new dk.wildside.util.Iterator();
	//alert(onlyEvents.length);
	if (typeof onlyEvents == 'array') {
		events.merge(onlyEvents);
	} else {
		events.merge(['change', 'click', 'keydown', 'keyup', 'keypress', 'focus', 'blur',
		              'mouseover', 'mousemove', 'mouseenter', 'mouseleave', 'mouseup', 
		              'mousedown', 'resize', 'select', 'scroll', 'submit']);
	};
	events.each(function(eventType) {
		//console.info('Binding: '+eventType);
		//alert('Binding; '+ eventType);
		context.bind(eventType, parent.dispatchEvent).data('instance', parent);
	});

};
