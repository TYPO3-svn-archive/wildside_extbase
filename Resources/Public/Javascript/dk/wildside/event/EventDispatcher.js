

Dk_Wildside_Event_EventDispatcher = function() {
	this.listeners = {};
	var eventType;
	for (eventType in Dk_Wildside_Event_WidgetEvent) {
		this.listeners[Dk_Wildside_Event_WidgetEvent[eventType]] = new Dk_Wildside_Util_Iterator();
	};
};

Dk_Wildside_Event_EventDispatcher.prototype.hasEventListener = function(eventType, func) {
	return this.listeners[eventType].contains(func);
};

Dk_Wildside_Event_EventDispatcher.prototype.addEventListener = function(eventType, func) {
	this.listeners[eventType].push(listener); 
};

Dk_Wildside_Event_EventDispatcher.prototype.removeEventListener = function(eventType, func) {
	this.listeners[eventType] = this.listeners[eventType].remove(func);
};

Dk_Wildside_Event_EventDispatcher.prototype.dispatchEvent = function(eventType) {
	console.log(eventType);
	console.log(this.listeners);
	return this.listeners[eventType].each(function(func) { func(this); });
};