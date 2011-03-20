
dk.wildside.display.field.Button = function(jQueryElement) {

	dk.wildside.display.field.Field.call(this, jQueryElement);
		
	this.fieldContext = this.context.find(':input');
	this.fieldContext.data('field', this);
	
	dk.wildside.event.EventAttacher.attachEvent(dk.wildside.event.MouseEvent.CLICK, this.fieldContext);
	if (this.fieldContext.attr('type') == 'submit') {
		this.addEventListener(dk.wildside.event.MouseEvent.CLICK, this.onSubmit);
	};
	
};

dk.wildside.display.field.Button.prototype = new dk.wildside.display.field.Field();

dk.wildside.display.field.Button.prototype.onReset = function() {
	
};

dk.wildside.display.field.Button.prototype.onSubmit = function() {
	var widget = this.getParent();
	if (widget) {
		var component = widget.getParent();
		if (component) {
			component.sync();
		};
	};
};

dk.wildside.display.field.Button.prototype.onClick = function() {
	
};