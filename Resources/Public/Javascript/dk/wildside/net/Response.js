Dk_Wildside_Net_Response = function(request) {
	this.request = null;
	this.raw = null;
	this.json = null;
	this.setRequest(request);
	return this;
};

Dk_Wildside_Net_Response.prototype.setRequest = function(request) {
	this.request = request;
	return this;
};

Dk_Wildside_Net_Response.prototype.getRequest = function() {
	return this.request;
};

Dk_Wildside_Net_Response.prototype.getAjax = function() {
	return this.getRequest().getAjax();
};

Dk_Wildside_Net_Response.prototype.getData = function() {
	var ajax = this.getAjax();
	console.log(ajax);
	if (ajax.responseCode == 200) {
		return jQuery.parseJSON(ajax.responseText);
	} else {
		return {};
	};
};