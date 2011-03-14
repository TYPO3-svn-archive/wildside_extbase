

dk.wildside.util.Iterator = function(length) {
	try {
		Array.apply(this, length);
	} catch (e) {};
	return this;
};

dk.wildside.util.Iterator.prototype = new Array();

dk.wildside.util.Iterator.prototype.filter = function(func) {
	
	var returnData = new dk.wildside.util.Iterator();
	
	jQuery.each(this, function(iteration, data) {
		
		// Run the passed function with "this" as scope, and store its return value
		var tempvalue = func.call(this, data, iteration);
		
		// If the returnvalue strict-matches true, save it in the return data.
		if (tempvalue === true) {
			returnData.push(data);
		};
	});
	
	// Return only matching data.
	return returnData;
	
};

dk.wildside.util.Iterator.prototype.each = function(func) {
	
	// Run the passed function ("func"), with "this" as scope, on each element in the
	// object. Please note that the order of the objects is reversed compared to
	// the jQuery norm, so func is called by: func(data, iteration);
	jQuery.each(this, function(iteration, data) {
		func.call(this, data, iteration);
	});
	
	// Return the original gangsta for chaining goodness.
	return this;
};

dk.wildside.util.Iterator.prototype.copy = function() {
	var copy = new dk.wildside.util.Iterator();
	this.each(function(element) { copy.push(element); });
	return copy;
};

dk.wildside.util.Iterator.prototype.toArray = function() {
	var arr = new Array();
	this.each(function(element) { arr.push(element); });
	return arr;
};

dk.wildside.util.Iterator.prototype.remove = function(arg) {
	// Use internal filter to return everything that DOESN'T match the argument passed along
	return this.filter(function(data){ return (data != arg); });
	
};

dk.wildside.util.Iterator.prototype.contains = function(arg) {
	// Use internal filter to count the entries that match the argument passed along.
	return this.filter(function(data){ return (data == arg); }).length;
};


dk.wildside.util.Iterator.prototype.merge = function(arr) {
	for (i = 0; i < arr.length; i++) {
		this.push(arr[i]);
	};
	return this;
};