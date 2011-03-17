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
	this.__widget = this;
	this.events = dk.wildside.event.widget.WidgetEvent;
	this.selectors = dk.wildside.util.Configuration.guiSelectors;
	// internals
	this.fields = new dk.wildside.util.Iterator();
	this.disabled = false;
	this.dirty = false;
	this.component = false;
	this.defaultAction = this.config.action;
	
	var widget = this;
	var json = jQuery.parseJSON(this.context.find("> ." + this.selectors.json).text().trim());
	var widgetType = json.widget;
	eval("if (typeof(" + widgetType + ") != 'undefined') " + widgetType + ".call(this);");
	
	// event listeners
	this.addEventListener(this.events.DIRTY, this.onDirty, this);
	this.addEventListener(this.events.CLEAN, this.onClean, this);
	this.addEventListener(this.events.ERROR, this.onError, this);
	
	// Regular field bootstrapping. This is for regular jackoffs.
	this.context.find(':input,.aloha').each(function() {
		var obj = jQuery(this)
		var sel = "." + widget.selectors.json;
		var fieldJSON = jQuery.parseJSON(obj.prevAll(sel).text().trim());
		var fieldType = fieldJSON.type;
		var field;
		eval("if (typeof " + fieldType + " != 'undefined') field = new " + fieldType + "(this);");
		if (field) {
			//console.info(widget);
			//console.log(fieldType);
			widget.registerField(field);
		} else {
			//console.warn('Unrecognized field type: ' + fieldType);
		};
	});
	
	return this;
};

dk.wildside.display.widget.Widget.prototype = new dk.wildside.display.DisplayObject;






// REGISTRATION / CONSTRUCTION / CONFIGURATION METHODS
dk.wildside.display.widget.Widget.prototype.registerComponent = function(component) {
	// Allow only ONE Component per widget; moving widgets between components
	// is bad - we can't assume all EventListeners have been removed...
	if (this.component) {
		return this;
	};
	// Remove native dirty-listener (set by constructor) first to let Component
	// manage sync strategy and prevent widget vigilantes ;)
	this.removeEventListener(dk.wildside.event.Event.DIRTY, this.onDirty, this);
	this.component = component;
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
	var parent = this.context.parents(this.selectors.itemParentLookup + ":first").find("." + this.selectors.messageDisplayElement + ":first");
	messages.each(function(message) {
		var msgObj = jQuery("<div>");
		msgObj.html(message).addClass(this.selectors.messageClassInfo);
		parent.append(msgObj);
	});
};







// DATA MANIPULATION METHODS
// TODO: consider removing these and replacing them with entirely Fields-based
// value storage. Bonuses include smaller Widget memory usage, event capabilities
// for each value (nice!) and of course sanitizer-support.
dk.wildside.display.widget.Widget.prototype.setValue = function(field, value) {
	this.fields.find(field).setValue(value);
};

dk.wildside.display.widget.Widget.prototype.getValue = function(field) {
	return this.fields.find(field).getValue();
};

dk.wildside.display.widget.Widget.prototype.setValues = function(object) {
	for (var name in object) {
		this.setValue(name, object[name]);
	};
	this.markClean();
	this.dispatchEvent(this.events.UPDATED);
};

dk.wildside.display.widget.Widget.prototype.getValues = function() {
	var values = {}; //this.config.data;
	this.fields.each(function(field) {
		values[field.getName()] = field.getValue();
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
		return this.dispatchEvent(this.events.ERROR, errors);
	} else {
		this.setValues(data);
		if (messages.length > 0) {
			this.dispatchEvent(this.events.MESSAGE, messages);
		};
	};
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.SYNC);
	return this;
};





// EVENT LISTENER METHODS
dk.wildside.display.widget.Widget.prototype.onError = function(event) {
	var errors = event.target;
	this.displayErrors(errors);
};

dk.wildside.display.widget.Widget.prototype.onDirty = function(event) {
	this.dirty = true;
	//console.info('Widget is dirty');
	if (this.component == false) {
		this.sync();
	};
};

dk.wildside.display.widget.Widget.prototype.onClean = function(event) {
	this.dirty = false;
};

dk.wildside.display.widget.Widget.prototype.onMessage = function(event) {
	var messages = event.target;
	this.displayMessages(messages);
};

