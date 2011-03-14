Dk_Wildside_Net_Responder = function(response, ajax) {
	this.response = null;
	this.setResponse(response);
	this.ajax = ajax;
	return this;
};

Dk_Wildside_Net_Responder.prototype.dispatchResponder = function() {
	return this.response.getData();
};

Dk_Wildside_Net_Responder.prototype.getResponse = function() {
	return this.response;
};

Dk_Wildside_Net_Responder.prototype.setResponse = function(response) {
	this.response = response;
	return this;
};

Dk_Wildside_Net_Responder.prototype.getAjax = function() {
	return this.getResponse().getAjax();
};

Dk_Wildside_Net_Responder.prototype.getData = function() {
	var data = this.response.getData(); 
	if (data) {
		var payload = data.payload;
		return payload;
	} else {
		return {};
	}
};

Dk_Wildside_Net_Responder.prototype.getMessages = function() {
	var messages = new Dk_Wildside_Util_Iterator();
	var data = this.getData();
	if (typeof data != 'undefined' && data.message) {
		messages.merge(data.messages);
	};
	return messages;
};

Dk_Wildside_Net_Responder.prototype.getErrors = function() {
	var errors = new Dk_Wildside_Util_Iterator();
	var data = this.getData();
	if (typeof data != 'undefined' && data.errors) {
		errors.merge(data.errors);
	} else {
		errors.push('Invalid server response: ' + this.getAjax().responseText);
	};
	return errors;
};