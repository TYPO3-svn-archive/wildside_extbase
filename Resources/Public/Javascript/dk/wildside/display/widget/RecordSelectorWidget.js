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
	
	this.value = this.config.value; 
	this.addEventListener(dk.wildside.event.widget.RecordSelectorEvent.SEARCH, this.onSearch);
};


dk.wildside.display.widget.RecordSelectorWidget.prototype = new dk.wildside.display.widget.Widget();



// DATA MANIPULATIO METHODS
dk.wildside.display.widget.RecordSelectorWidget.setValue = function() {
	
};

dk.wildside.display.widget.RecordSelectorWidget.getValue = function() {
	
};



// EVENT LISTENER METHODS
dk.wildside.display.widget.RecordSelectorWidget.prototype.onSearch = function(event) {
	
};

dk.wildside.display.widget.RecordSelectorWidget.prototype.onResult = function(event) {
	
};

dk.wildside.display.widget.RecordSelectorWidget.prototype.onSelect = function(event) {
	
};

dk.wildside.display.widget.RecordSelectorWidget.prototype.onAdd = function(event) {
	
};

dk.wildside.display.widget.RecordSelectorWidget.prototype.onRemove = function(event) {
	
};

dk.wildside.display.widget.RecordSelectorWidget.prototype.onSort = function(event) {
	
};