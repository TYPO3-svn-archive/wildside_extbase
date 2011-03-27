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
	dk.wildside.display.widget.Widget.call(this, jQueryElement);
	
	this.resultList = this.children.find('results');
	this.resultList.context.html('<ul></ul>');
	this.memberList = this.children.find('selections');
	this.memberList.context.html('<ul></ul>');
	
	var qField = this.children.find('q');
	// remove the default CHANGE event listener on 'q'
	//qField.removeEventListener(dk.wildside.event.FieldEvent.CHANGE);
	// remove anything listening to BLUR on the search field. KEYPRESS should be used
	//dk.wildside.event.EventAttacher.detachEvent(dk.wildside.event.FieldEvent.BLUR, qField.fieldContext);
	// make the 'q' field react to keypress, fire SEARCH event when key pressed
	//dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.FieldEvent.KEYPRESS, qField.fieldContext);
	// use the DIRTYFIELD listener to determine which action was requested (by which Field triggered the event)
	this.addEventListener(dk.wildside.event.FieldEvent.KEYPRESS, this.onDirtyField);
	// make the widget itself listen for requests to start searching - these can come from the outside too
	this.addEventListener(dk.wildside.event.widget.RecordSelectorEvent.SEARCH, this.onSearch);
	// listen to own Events of type 'results received' (response containing listable results data)
	this.addEventListener(dk.wildside.event.widget.RecordSelectorEvent.RESULT, this.onResult);
	// listen to own Events of type 'result clicked' (clicking a result in the result list)
	this.addEventListener(dk.wildside.event.widget.RecordSelectorEvent.ADD, this.onAdd);
	// listen to own Events of type 'selection clicked' (can be an icon inside selection, which triggers the event - could use to remove, edit, sort etc)
	this.addEventListener(dk.wildside.event.widget.RecordSelectorEvent.SELECT, this.onSelect);
	// listen to own Events of type 'selection removed' (will fire when an entry is removed; the Event will contain a reference to what was removed)
	this.addEventListener(dk.wildside.event.widget.RecordSelectorEvent.REMOVE, this.onRemove);
	
	
	var testMember = {
		value : 1,
		label : 'Test-member'
	};
	this.resultList.addMember(testMember);
	this.resultList.addMember(testMember);
	this.resultList.addMember(testMember);
	this.resultList.addMember(testMember);
	
};


dk.wildside.display.widget.RecordSelectorWidget.prototype = new dk.wildside.display.widget.Widget();



// DATA MANIPULATION METHODS
/*
dk.wildside.display.widget.RecordSelectorWidget.setValue = function() {
	// setting the value should analyze the current list of values, ignore existing, 
	// remove entries not in the new value and finally call selectResult(resultUid) on 
	// each new entry - to allow onAdd events to fire, in case a subclasser wants to 
	// perform custom actions such as resolving additional information or setting a 
	// special class on selected new additions
};

dk.wildside.display.widget.RecordSelectorWidget.getValue = function() {
	// should return the value either as an array of values or as a single CSV
	// string value - according to the this.config.dataType parameter
};
*/











// EVENT LISTENER METHODS
dk.wildside.display.widget.RecordSelectorWidget.prototype.onDirtyField = function(event) {
	// TODO: change this from a wrapper into a single listener - if no other Fields except for 'q' are needed
	event.cancelled = true;
	var field = event.target;
	var newEvent = {
		target : this,
		currentTarget : this
	};
	switch (field.getName()) {
		case 'q':
			newEvent.type = dk.wildside.event.widget.RecordSelectorEvent.SEARCH;
			break;
		default:
			newEvent.type = dk.wildside.event.widget.RecordSelectorEvent.NOOP;
			break;
	}
	console.log(newEvent.type);
	this.dispatchEvent(newEvent);
};

dk.wildside.display.widget.RecordSelectorWidget.prototype.onSearch = function(event) {
	var queryString = this.children.find('q').getValue();
	if (queryString.length < 3) {
		console.warn('Waiting for string length of 3: ' + queryString.length.toString());
		event.cancelled = true;
		return;
	};
	console.log('searching...');
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