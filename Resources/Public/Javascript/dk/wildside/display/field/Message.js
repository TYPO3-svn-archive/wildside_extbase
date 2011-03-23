

dk.wildside.display.field.Message = function(jQueryElement) {
	dk.wildside.display.field.Field.call(this, jQueryElement);
	this.identity = 'field.Message';
	this.fieldContext = this.context.children().last();
	this.addEventListener(dk.wildside.event.FieldEvent.BLUR, this.onChange);
	if (this.config.hidden > 0) {
		this.hide();
	}
};

dk.wildside.display.field.Message.prototype = new dk.wildside.display.field.Field();

dk.wildside.display.field.Message.prototype.getValue = function() {
	return this.fieldContext.val();
};

dk.wildside.display.field.Message.prototype.setValue = function(val) {
	if (val.length == 0) {
		return;
	};
	this.value = val;
	var arr = new Array();
	arr.push('<ul>');
	for (var i=0; i<val.length; i++) {
		var msg = val[i];
		arr.push('<li>' + msg.title + ' ' + msg.message + ' (code ' + msg.severity +')</li>');
	};
	arr.push('</ul>');
	this.fieldContext.html(arr.join("\n"));
	this.fadeIn();
	var target = this;
	setTimeout(function() { target.fadeOut(); }, parseInt(this.config.timeout) * 1000 );
};