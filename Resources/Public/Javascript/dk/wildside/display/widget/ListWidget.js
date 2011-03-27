// Widget to render list-style displays by calling various input control methods.
// Dispatches events from clicked members which can be listened to by outside 
// Widgets/Components.
// Should be named using setName(myUniqueName) or through a ViewHelper; can then be referenced 
// by any parent Widget/Component by calling this.children.find(myUniqueName);

dk.wildside.display.widget.ListWidget = function(jQueryElement) {
	if (typeof jQueryElement == 'undefined') {
		return this;
	};
	dk.wildside.display.widget.Widget.call(this, jQueryElement);
	this.members = new dk.wildside.util.Iterator();
};

dk.wildside.display.widget.ListWidget.prototype = new dk.wildside.display.widget.Widget();

dk.wildside.display.widget.ListWidget.prototype.checkMember = function(member) {
	if (typeof member != 'object') {
		console.info('Member must be an object.');
		return false;
	};
	if (!member.label) {
		member.label = member.value;
	};
	if (!member.value || !member.label) {
		console.info('Member must have both .value and .label properties');
	};
	return true;
};

dk.wildside.display.widget.ListWidget.prototype.checkMembers = function(input) {
	if (typeof members != 'array' && members instanceof dk.wildside.util.Iterator) {
		console.info('ListWidget does not know what to do with this value:');
		console.warn(members);
		return false;
	};
	return true;
};

dk.wildside.display.widget.ListWidget.prototype.addMember = function(member) {
	if (!this.checkMember(member)) {
		return;
	};
	// translate the member info to a usable dk.wildside.display.Sprite, add to child list
	// and attach the necessary event listener to react to selection
	var sprite = new dk.wildside.display.Sprite('<li title="' + member.value + '">MEMBER: ' + member.label + '</li>');
	//dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.MouseEvent.CLICK, sprite.context);
	//sprite.addEventListener(dk.wildside.event.MouseEvent.CLICK, sprite.dispatchEvent); // re-dispatch as WS Event
	this.addChild(sprite, true); // add child AND insert HTML
	//this.setCaptureJQueryEvents(true, sprite);
};

dk.wildside.display.widget.ListWidget.prototype.removeMember = function(member) {
	if (!this.checkMember(member)) {
		return;
	};
};

dk.wildside.display.widget.ListWidget.prototype.addMembers = function(members) {
	if (!this.checkMembers(members)) {
		return;
	};
	var iterator = new dk.wildside.util.Iterator().merge(members);
	var parent = this;
	iterator.each(function(member) { parent.addMember.call(parent, member); });
};

dk.wildside.display.widget.ListWidget.prototype.removeMembers = function(members) {
	if (!this.checkMembers(members)) {
		return;
	};
	var iterator = new dk.wildside.util.Iterator().merge(members);
	var parent = this;
	iterator.each(function(member) { parent.removeMember.call(parent, member); });
};

dk.wildside.display.widget.ListWidget.prototype.removeAllMembers = function() {
	
};

dk.wildside.display.widget.ListWidget.prototype.onClick = function(event) {
	this.onSelectMember(event);
};

// NOTE: this function should analyze the event.originalEvent to determine which member was clicked
dk.wildside.display.widget.ListWidget.prototype.onSelectMember = function(event) {
	console.info('Member clicked, event:');
	console.warn(event);
};