
dk.wildside.display.field.Button = function(jQueryElement) {

	dk.wildside.display.field.Field.call(this, jQueryElement);
		
	this.fieldContext = this.context.find(':input');
	this.fieldContext.data('field', this);
	
	if (this.fieldContext.attr('type') == 'submit') {
		this.addEventListener(dk.wildside.event.MouseEvent.CLICK, this.onSubmit);
		this.captureJQueryEvents(['click'], this.fieldContext, this);
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