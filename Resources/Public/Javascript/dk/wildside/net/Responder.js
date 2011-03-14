dk.wildside.net.Responder = function(response, ajax) {
	this.response = null;
	this.setResponse(response);
	this.ajax = ajax;
	return this;
};

dk.wildside.net.Responder.prototype.dispatchResponder = function() {
	return this.response.getData();
};

dk.wildside.net.Responder.prototype.getResponse = function() {
	return this.response;
};

dk.wildside.net.Responder.prototype.setResponse = function(response) {
	this.response = response;
	return this;
};

dk.wildside.net.Responder.prototype.getAjax = function() {
	return this.getResponse().getAjax();
};

dk.wildside.net.Responder.prototype.getData = function() {
	var data = this.response.getData(); 
	if (data) {
		var payload = data.payload;
		return payload;
	} else {
		return {};
	}
};

dk.wildside.net.Responder.prototype.getMessages = function() {
	var messages = new dk.wildside.util.Iterator();
	var data = this.getData();
	if (typeof data != 'undefined' && data.message) {
		messages.merge(data.messages);
	};
	return messages;
};

dk.wildside.net.Responder.prototype.getErrors = function() {
	var errors = new dk.wildside.util.Iterator();
	var data = this.getData();
	if (typeof data != 'undefined' && data.errors) {
		errors.merge(data.errors);
	} else {
		errors.push('Invalid server response: ' + this.getAjax().responseText);
	};
	return errors;
};