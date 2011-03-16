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

dk.wildside.display.widget.Widget = function() {
	dk.wildside.display.DisplayObject.apply(this, arguments);
	this.values = {};
	this.messages = {};
	this.disabled = false;
	this.dirty = false;
	this.component = false;
	this.fields = new dk.wildside.util.Iterator;
	this.defaultAction = 'update';
	this.configuration = {};
	this.action = this.defaultAction;
};

dk.wildside.display.widget.Widget.prototype = new dk.wildside.display.DisplayObject();

dk.wildside.display.widget.Widget.prototype.enableControls = function() {
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.PRE_ENABLE);
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.ENABLED);
};

dk.wildside.display.widget.Widget.prototype.disableControls = function() {
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.PRE_DISABLE);
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.DISABLED);
};

dk.wildside.display.widget.Widget.prototype.sync = function() {
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.PRE_SYNC);
	//this.action = this.defaultAction;
	
	var request = new dk.wildside.net.Request(this);
	var responder = new dk.wildside.net.Dispatcher(request).dispatchRequest();
	var data = responder.getData();
	var messages = responder.getMessages();
	var errors = responder.getErrors();
	
	if (errors.length > 0) {
		this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.ERROR);
		return this.displayErrors(errors);
	} else {
		this.setValues(data);
		if (messages.length > 0) {
			this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.MESSAGE);
			this.displayMessages(messages);
			this.clearMessages();
		};
		this.setClean();
	};
	
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.COMPLETE);
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.SYNC);
};

dk.wildside.display.widget.Widget.prototype.remove = function() {
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.PRE_DELETE);
	this.setAction('delete');
	return this.sync();
};

dk.wildside.display.widget.Widget.prototype.update = function() {
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.PRE_UPDATE);
	this.setAction('update');
	return this.sync();
};

dk.wildside.display.widget.Widget.prototype.create = function() {
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.PRE_CREATE);
	this.setAction('create');
	return this.sync();
};

dk.wildside.display.widget.Widget.prototype.displayErrors = function(messages) {
	var parent = this.context.parents(dk.wildside.util.Configuration.guiSelectors.itemParentLookup + ":first").find("." + dk.wildside.util.Configuration.guiSelectors.messageDisplayElement + ":first");
	messages.each(function(message) {
		var msgObj = jQuery("<div>");
		msgObj.html(message);
		msgObj.addClass(dk.wildside.util.Configuration.guiSelectors.messageClassError);
		parent.append(msgObj);
	});
};

dk.wildside.display.widget.Widget.prototype.displayMessages = function(messages) {
	var parent = this.context.parents(dk.wildside.util.Configuration.guiSelectors.itemParentLookup + ":first").find("." + dk.wildside.util.Configuration.guiSelectors.messageDisplayElement + ":first");
	messages.each(function(message) {
		var msgObj = jQuery("<div>");
		msgObj.html(message);
		msgObj.addClass(dk.wildside.util.Configuration.guiSelectors.messageClassInfo);
		parent.append(msgObj);
	});
};

dk.wildside.display.widget.Widget.prototype.getDirty = function() {
	return this.dirty;
};

dk.wildside.display.widget.Widget.prototype.setDirty = function() {
	this.dirty = true;
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.DIRTY);
};

dk.wildside.display.widget.Widget.prototype.setClean = function() {
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.CLEAN);
	this.dirty = false;
};

dk.wildside.display.widget.Widget.prototype.clearMessages = function() {
	this.messages = {};
};

dk.wildside.display.widget.Widget.prototype.message = function(msg, field) {
	if (field == undefined) {
		this.messages.push(msg);
	} else {
		this.messages[field] = msg;
	};
};

dk.wildside.display.widget.Widget.prototype.setValues = function(object) {
	for (var name in object) {
		this.setValue(name, object[name]);
	};
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.UPDATED);
	this.dispatchEvent(dk.wildside.event.widget.WidgetEvent.COMPLETE);
};

dk.wildside.display.widget.Widget.prototype.getFields = function() {
	return this.fields;
};

dk.wildside.display.widget.Widget.prototype.setFields = function(fields) {
	this.fields = fields;
};

dk.wildside.display.widget.Widget.prototype.getValues = function() {
	var values = this.values;
	var config = this.getConfiguration();
	this.fields.each(function(field) {
		var fieldName = field.getName();
		values[fieldName] = field.getValue();
	});
	if (config.data.uid > 0) {
		values['__identity'] = config.data.uid;
	}
	this.values = values;
	return this.values;
};

dk.wildside.display.widget.Widget.prototype.getConfiguration = function() {
	return jQuery.parseJSON(this.context.find('.' + dk.wildside.util.Configuration.guiSelectors.json).html());
};

dk.wildside.display.widget.Widget.prototype.setAction = function(action) {
	this.action = action;
};

dk.wildside.display.widget.Widget.prototype.setValue = function(field, value) {
	this.values[field] = value;
};

dk.wildside.display.widget.Widget.prototype.getValue = function(field) {
	return this.values[field];
};

dk.wildside.display.widget.Widget.prototype.setComponent = function(component) {
	this.component = component;
	return this;
};

dk.wildside.display.widget.Widget.prototype.getComponent = function() {
	return this.component;
};
