




dk.wildside.display.field.Sanitizer = new function() {
	
	this.noop = function(value) {
		return value;
	};
	
	this.integer = function(value) {
		value = value.toString();
		value = value.replace(/[^0-9]/g, '');
		if (!value) value = 0;
		return value;
	};
	
	this.float = function(value) {
		value = value.toString();
		if (!/^[0-9]{0,}[\.,]{0,1}[0-9]{0,}$/.test(value)) {
			value = "0";
		};
		return value;
	};
	
	this.string = function(value) {
		
		return value;
	};
	
	this.preg = function(value, preg) {
		
		return value;
	};
	
};

