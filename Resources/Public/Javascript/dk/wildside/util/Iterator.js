

Dk_Wildside_Util_Iterator = function(length) {
	try {
		Array.apply(this, length);
	} catch (e) {};
	return this;
};

Dk_Wildside_Util_Iterator.prototype = new Array();

Dk_Wildside_Util_Iterator.prototype.filter = function(func) {
	
	var returnData = new Dk_Wildside_Util_Iterator();
	
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

Dk_Wildside_Util_Iterator.prototype.each = function(func) {
	
	// Run the passed function ("func"), with "this" as scope, on each element in the
	// object. Please note that the order of the objects is reversed compared to
	// the jQuery norm, so func is called by: func(data, iteration);
	jQuery.each(this, function(iteration, data) {
		func.call(this, data, iteration);
	});
	
	// Return the original gangsta for chaining goodness.
	return this;
};

Dk_Wildside_Util_Iterator.prototype.copy = function() {
	var copy = new Dk_Wildside_Util_Iterator();
	this.each(function(element) { copy.push(element); });
	return copy;
};

Dk_Wildside_Util_Iterator.prototype.toArray = function() {
	var arr = new Array();
	this.each(function(element) { arr.push(element); });
	return arr;
};

Dk_Wildside_Util_Iterator.prototype.remove = function(arg) {
	// Use internal filter to return everything that DOESN'T match the argument passed along
	return this.filter(function(data){ return (data != arg); });
	
};

Dk_Wildside_Util_Iterator.prototype.contains = function(arg) {
	// Use internal filter to count the entries that match the argument passed along.
	return this.filter(function(data){ return (data == arg); }).length;
};


Dk_Wildside_Util_Iterator.prototype.merge = function(arr) {
	for (i = 0; i < arr.length; i++) {
		this.push(arr[i]);
	};
	return this;
};