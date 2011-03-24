/***************************************************************
* Widget - Base Class
* 
* Base class for interactive interface objects (widgets) used 
* to manipulate data, collect data from the object, update 
* the object's visual elements using data returned from controller 
* calls and various GUI-related operations relevant for interactive 
* elements (such as enable and disable).
* 
***************************************************************/

dk.wildside.display.widget.Widget = function(jQueryElement) {
	if (typeof jQueryElement == 'undefined') {
		return this;
	};
	dk.wildside.display.DisplayObject.call(this, jQueryElement);
	
	// references
	this.events = dk.wildside.event.widget.WidgetEvent;
	this.selectors = dk.wildside.util.Configuration.guiSelectors;
	
	// internals
	this.fields = new dk.wildside.util.Iterator();
	this.widgets = new dk.wildside.util.Iterator();
	this.messages = new dk.wildside.util.Iterator();
	this.disabled = false;
	this.dirty = false;
	this.name = this.config.name;
	this.defaultAction = this.config.action;
	
	// identity
	if (typeof this.identity == 'undefined') {
		this.identity = 'widget';
	};
	
	// event listeners
	this.addEventListener(this.events.DIRTY, this.onDirty);
	this.addEventListener(this.events.CLEAN, this.onClean);
	this.addEventListener(this.events.ERROR, this.onError);
	this.addEventListener(this.events.REFRESH, this.onRefresh);
	this.addEventListener(this.events.MESSAGE, this.onMessage);
	this.addEventListener(dk.wildside.event.FieldEvent.DIRTY, this.onDirtyField);
	this.addEventListener(dk.wildside.event.FieldEvent.CLEAN, this.onCleanField);
	
	// Regular field and sub-Widget bootstrapping.
	var widget = this; // Necessary reference for the following jQuery enclosure
	this.context.find("." + this.selectors.widget +":not(." + this.selectors.inUse +")").each( function() {
		var obj = jQuery(this)
		var widgetAsField = dk.wildside.spawner.get(obj);
		widget.registerField(widgetAsField); // catch events from sub-Widgets
	} );
	this.context.find("." + this.selectors.field).each(function() {
		var obj = jQuery(this)
		var field = dk.wildside.spawner.get(obj);
		widget.registerField(field);
	});
	
	return this;
};

dk.wildside.display.widget.Widget.prototype = new dk.wildside.display.DisplayObject;



// REGISTRATION / CONSTRUCTION / CONFIGURATION METHODS
dk.wildside.display.widget.Widget.prototype.registerComponent = function(component) {
	// Remove native dirty-listener (set by constructor) first to let Component
	// manage sync strategy and prevent widget vigilantes ;)
	this.removeEventListener(dk.wildside.event.Event.DIRTY, this.onDirty);
	return this;
};

dk.wildside.display.widget.Widget.prototype.registerField = function(field) {
	field.setParent(this);
	this.fields.push(field);
};

dk.wildside.display.widget.Widget.prototype.getConfiguration = function() {
	return this.config;
};




// DISPLAY MANIPULATION METHODS
dk.wildside.display.widget.Widget.prototype.enableControls = function() {
	this.dispatchEvent(this.events.PRE_ENABLE);
	this.disabled = false;
	// TODO: enable controls in GUI
	this.dispatchEvent(this.events.ENABLED);
};

dk.wildside.display.widget.Widget.prototype.disableControls = function() {
	this.dispatchEvent(this.events.PRE_DISABLE);
	this.disabled = true;
	// TODO: disable controls in GUI
	this.dispatchEvent(this.events.DISABLED);
};

dk.wildside.display.widget.Widget.prototype.displayErrors = function(messages) {
	var parent = this.context.parents(this.selectors.itemParentLookup + ":first").find("." + this.selectors.messageDisplayElement + ":first");
	messages.each(function(message) {
		var msgObj = jQuery("<div>");
		msgObj.html(message).addClass(selectors.messageClassError);
		parent.append(msgObj);
	});
};

dk.wildside.display.widget.Widget.prototype.displayMessages = function(messages) {
	var container = this.fields.find('messages');
	if (typeof container != 'undefined') {
		return container.setValue.call(container, messages);
	} else {
		var message = new String();
		for (var i=0; i<messages.length; i++) {
			var msg = messages[i];
			message += msg.title + ' ' + msg.message + ' (' + msg.severity + ')';
		}
		return alert(message);
	};
};





// DATA MANIPULATION METHODS
// value storage. Bonuses include smaller Widget memory usage, event capabilities
// for each value (nice!) and of course sanitizer-support.
dk.wildside.display.widget.Widget.prototype.setValue = function(value) {
	// default action is to do nothing - custom Widgets masquerading as Fields override this method
};

dk.wildside.display.widget.Widget.prototype.getValue = function() {
	// default action is to return undefined - custom Widgets masquerading as Fields override this method
	return undefined;
};

dk.wildside.display.widget.Widget.prototype.setName = function(value) {
	this.name = value;
};

dk.wildside.display.widget.Widget.prototype.getName = function() {
	this.name;
};

dk.wildside.display.widget.Widget.prototype.setValues = function(object) {
	for (var name in object) {
		this.setValue(name, object[name]);
	};
	this.markClean();
	this.dispatchEvent(this.events.UPDATED);
};

dk.wildside.display.widget.Widget.prototype.getValues = function() {
	var values = {};
	var widget = this;
	this.fields.each(function(field) {
		if (typeof widget.config.data[field.getName()] != 'undefined') {
			values[field.getName()] = field.getValue();
		};
	});
	return values;
};





// MODEL OBJECT INTERACTION METHODS
dk.wildside.display.widget.Widget.prototype.markDirty = function() {
	this.dirty = true;
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.DIRTY);
};

dk.wildside.display.widget.Widget.prototype.markClean = function() {
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.CLEAN);
	this.dirty = false;
};

dk.wildside.display.widget.Widget.prototype.rollback = function() {
	this.fields.each(function(field) { field.rollback(); });
};

dk.wildside.display.widget.Widget.prototype.remove = function() {
	this.dispatchEvent(this.events.PRE_DELETE);
	this.config.action = 'delete';
	this.sync();
	return this;
};

dk.wildside.display.widget.Widget.prototype.update = function() {
	this.dispatchEvent(this.events.PRE_UPDATE);
	this.config.action = 'update';
	this.sync();
	return this;
};

dk.wildside.display.widget.Widget.prototype.create = function() {
	this.dispatchEvent(this.events.PRE_CREATE);
	this.config.action = 'create';
	this.sync();
	this.config.action = this.defaultAction;
	return this;
};

dk.wildside.display.widget.Widget.prototype.sync = function() {
	this.dispatchEvent(this.events.PRE_SYNC);
	var request = new dk.wildside.net.Request(this);
	var responder = new dk.wildside.net.Dispatcher(request).dispatchRequest();
	var data = responder.getData();
	var messages = responder.getMessages();
	var errors = responder.getErrors();
	if (errors.length > 0) {
		return this.dispatchEvent(this.events.ERROR);
	} else {
		this.setValues(data);
		this.dispatchEvent(this.events.CLEAN);
		//console.log(messages);
		if (messages.length > 0) {
			this.messages.merge(messages);
			this.dispatchEvent(this.events.MESSAGE);
		};
	};
	return this;
};

dk.wildside.display.widget.Widget.prototype.refresh = function() {
	
};

dk.wildside.display.widget.Widget.prototype.dispatchRequest = function(request) {
	var responder = new dk.wildside.net.Dispatcher(request).dispatchRequest();
	var data = responder.getData();
	var messages = responder.getMessages();
	var errors = responder.getErrors();
	if (errors.length > 0) {
		return this.dispatchEvent(this.events.ERROR);
	} else {
		if (messages.length > 0) {
			this.dispatchEvent(this.events.MESSAGE);
		};
		return {'data': data, 'messages': messages, 'errors': errors};
	};
};









// EVENT LISTENER METHODS
dk.wildside.display.Component.prototype.onRefresh = function(event) {
	
};

dk.wildside.display.widget.Widget.prototype.onError = function(event) {
	var errors = event.target;
	this.displayErrors(errors);
};

dk.wildside.display.widget.Widget.prototype.onDirtyField = function(event) {
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.DIRTY);
};

dk.wildside.display.widget.Widget.prototype.onCleanField = function(event) {
	//this.dispatchEvent(this.events.DIRTY);
};

dk.wildside.display.widget.Widget.prototype.onDirty = function(event) {
	this.dirty = true;
	if (this.component == false) {
		this.sync();
	};
};

dk.wildside.display.widget.Widget.prototype.onClean = function(event) {
	this.dirty = false;
};

dk.wildside.display.widget.Widget.prototype.onMessage = function(event) {
	var messages = this.messages;
	this.displayMessages(messages);
};

