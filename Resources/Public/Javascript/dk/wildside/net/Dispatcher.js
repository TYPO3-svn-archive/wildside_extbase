Dk_Wildside_Net_Dispatcher = function(request) {
	if (request instanceof Dk_Wildside_Net_Request == false) {
		this.request = new Dk_Wildside_Net_Request();
	} else{
		this.request = request;
	}
	this.response = new Dk_Wildside_Net_Response();
	this.responder = new Dk_Wildside_Net_Responder();
	return this;
};

Dk_Wildside_Net_Dispatcher.prototype.execute = function() {
	var responder = this.dispatchRequest();
	return responder.execute();
};

Dk_Wildside_Net_Dispatcher.prototype.dispatchRequest = function(request) {
	if (request instanceof Dk_Wildside_Net_Request == false) {
		request = this.request;
	};
	var controller = request.getWidget().getConfiguration().controller.toLowerCase();
	var scope = request.getScope();
	var data = {};
	data[scope] = {};
	data[scope][controller] = request.getWidget().getValues();
	var ajaxOptions = {
		async: false,
		type: 'post',
		url: request.getUrl(),
		data: data
	};
	var ajax = jQuery.ajax(ajaxOptions); // all HTTP happens right away
	request.setAjax(ajax);
	var response = new Dk_Wildside_Net_Response(request);
	var responder = new Dk_Wildside_Net_Responder(response);
	this.setResponse(response);
	this.setResponder(responder);
	return responder;
};

Dk_Wildside_Net_Dispatcher.prototype.setRequest = function(request) {
	this.request = request;
	return this;
};

Dk_Wildside_Net_Dispatcher.prototype.getRequest = function() {
	return this.request;
};

Dk_Wildside_Net_Dispatcher.prototype.setResponse = function(response) {
	this.response = response;
	return this;
};

Dk_Wildside_Net_Dispatcher.prototype.getResponse = function() {
	return this.response;
};

Dk_Wildside_Net_Dispatcher.prototype.setResponder = function(responder) {
	this.responder = responder;
	return this;
};

Dk_Wildside_Net_Dispatcher.prototype.getResponder = function() {
	return this.responder;
};

