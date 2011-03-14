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

Dk_Wildside_Display_Widget = function() {
	Dk_Wildside_Display_DisplayObject.apply(this, arguments);
	this.values = {};
	this.messages = {};
	this.disabled = false;
	this.dirty = false;
	this.parent = false;
	this.defaultAction = 'update';
	this.configuration = {};
	this.action = this.defaultAction;
};

Dk_Wildside_Display_Widget.prototype = new Dk_Wildside_Display_DisplayObject();

Dk_Wildside_Display_Widget.prototype.enableControls = function() {
	this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.PRE_ENABLE);
	this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.ENABLED);
};

Dk_Wildside_Display_Widget.prototype.disableControls = function() {
	this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.PRE_DISABLE);
	this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.DISABLED);
};

Dk_Wildside_Display_Widget.prototype.sync = function() {
	this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.PRE_SYNC);
	
	var request = new Dk_Wildside_Net_Request(this);
	var dispatcher = new Dk_Wildside_Net_Dispatcher(request).dispatchRequest();
	var data = dispatcher.getData();
	var messages = dispatcher.getMessages();
	var errors = dispatcher.getErrors();
	
	if (errors.length > 0) {
		this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.ERROR);
		return this.displayErrors(errors);
	} else {
		this.setValues(data);
		if (messages.length > 0) {
			this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.MESSAGE);
			this.displayMessages(messages);
		};
	};
	
	this.action = this.defaultAction;
	this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.COMPLETE);
	this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.SYNC);
};

Dk_Wildside_Display_Widget.prototype.remove = function() {
	this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.PRE_DELETE);
	this.setAction('delete');
	return this.sync();
};

Dk_Wildside_Display_Widget.prototype.update = function() {
	this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.PRE_UPDATE);
	this.setAction('update');
	return this.sync();
};

Dk_Wildside_Display_Widget.prototype.create = function() {
	this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.PRE_CREATE);
	this.setAction('create');
	return this.sync();
};

Dk_Wildside_Display_Widget.prototype.displayErrors = function(messages) {
	var parent = this.context.parents(Dk_Wildside_Util_Configuration.guiSelectors.itemParentLookup + ":first").find("." + Dk_Wildside_Util_Configuration.guiSelectors.messageDisplayElement + ":first");
	messages.each(function(message) {
		var msgObj = jQuery("<div>");
		msgObj.html(message);
		msgObj.addClass(Dk_Wildside_Util_Configuration.guiSelectors.messageClassError);
		parent.append(msgObj);
	});
};

Dk_Wildside_Display_Widget.prototype.displayMessages = function(messages) {
	var parent = this.context.parents(Dk_Wildside_Util_Configuration.guiSelectors.itemParentLookup + ":first").find("." + Dk_Wildside_Util_Configuration.guiSelectors.messageDisplayElement + ":first");
	messages.each(function(message) {
		var msgObj = jQuery("<div>");
		msgObj.html(message);
		msgObj.addClass(Dk_Wildside_Util_Configuration.guiSelectors.messageClassInfo);
		parent.append(msgObj);
	});
};

Dk_Wildside_Display_Widget.prototype.getDirty = function() {
	return this.dirty;
};

Dk_Wildside_Display_Widget.prototype.setDirty = function() {
	this.dirty = true;
	this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.DIRTY);
};

Dk_Wildside_Display_Widget.prototype.setClean = function() {
	this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.CLEAN);
	this.dirty = false;
};

Dk_Wildside_Display_Widget.prototype.clearMessages = function() {
	this.messages = {};
};

Dk_Wildside_Display_Widget.prototype.message = function(msg, field) {
	if (field == undefined) {
		this.messages.push(msg);
	} else {
		this.messages[field] = msg;
	};
};

Dk_Wildside_Display_Widget.prototype.setValues = function(object) {
	for (var name in object) {
		this.setValue(name, object[name]);
	};
	this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.UPDATED);
	this.dispatchEvent(Dk_Wildside_Event_WidgetEvent.COMPLETE);
};

Dk_Wildside_Display_Widget.prototype.getFields = function() {
	return this.fields;
};

Dk_Wildside_Display_Widget.prototype.setFields = function(fields) {
	this.fields = fields;
};

Dk_Wildside_Display_Widget.prototype.getValues = function() {
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

Dk_Wildside_Display_Widget.prototype.getConfiguration = function() {
	return jQuery.parseJSON(this.context.find('.' + Dk_Wildside_Util_Configuration.guiSelectors.json).html());
};

Dk_Wildside_Display_Widget.prototype.setAction = function(action) {
	this.action = action;
};

Dk_Wildside_Display_Widget.prototype.setValue = function(field, value) {
	this.values[field] = value;
};

Dk_Wildside_Display_Widget.prototype.getValue = function(field) {
	return this.values[field];
};

Dk_Wildside_Display_Widget.prototype.setParent = function(parent) {
	this.parent = parent;
	return this;
};

Dk_Wildside_Display_Widget.prototype.getParent = function() {
	return this.parent;
};
