/***************************************************************
* RecordSelectorWidget - Gui Object
* 
* Highly configurable Record Selector - acts as a regular Widget
* but allows you to manipulate the value of a field (or more fields 
* if you subclass this class) by selecting records from the 
* database through a list/search/order/add/remove-type interface
* 
***************************************************************/

dk.wildside.display.widget.RecordSelectorWidget = function(jQueryElement) {
	if (typeof jQueryElement == 'undefined') {
		return this;
	};
	dk.wildside.display.DisplayObject.call(this, jQueryElement);
	
	this.addEventListener(dk.wildside.event.widget.RecordSelectorEvent.SEARCH, this.onSearch);
};


dk.wildside.display.widget.RecordSelectorWidget.prototype = new dk.wildside.display.widget.Widget();



// DATA MANIPULATION METHODS
/*
dk.wildside.display.widget.RecordSelectorWidget.setValue = function() {
	
};

dk.wildside.display.widget.RecordSelectorWidget.getValue = function() {
	
};
*/







// EVENT LISTENER METHODS
dk.wildside.display.widget.RecordSelectorWidget.prototype.onDirtyField = function(event) {
	event.cancelled;
	var field = event.target;
	var newEvent = {
		target : this,
		currentTarget : this
	};
	switch (field.getName()) {
		case 'q':
			newEvent.type = dk.wildside.event.widget.RecordSelecetorWidgetEvent.SEARCH;
			break;
		default:
			newEvent.type = dk.wildside.event.widget.RecordSelectorWidgetEvent.NOOP;
			break;
	}
	console.log(newEvent.type);
	this.dispatchEvent(newEvent);
};

dk.wildside.display.widget.RecordSelectorWidget.prototype.onSearch = function(event) {
	
	
	event.cancelled = true;
};

dk.wildside.display.widget.RecordSelectorWidget.prototype.onResult = function(event) {
	
	event.cancelled = true;
};

dk.wildside.display.widget.RecordSelectorWidget.prototype.onSelect = function(event) {
	
	event.cancelled = true;
};

dk.wildside.display.widget.RecordSelectorWidget.prototype.onAdd = function(event) {
	
	event.cancelled = true;
};

dk.wildside.display.widget.RecordSelectorWidget.prototype.onRemove = function(event) {
	
	event.cancelled = true;
};

dk.wildside.display.widget.RecordSelectorWidget.prototype.onSort = function(event) {
	
};