Dk_Wildside_Net_Request = function(widget, action) {
	this.ajax = false;
	this.setWidget(widget);
	if (typeof(action) != 'undefined') {
		this.action = 'update';
	} else {
		this.action = this.widget.getConfiguration().action;
	};
};

Dk_Wildside_Net_Request.prototype.getScope = function() {
	var configuration = this.getWidget().getConfiguration();
	var plugin = configuration.plugin;
	return plugin;
};

Dk_Wildside_Net_Request.prototype.getUrl = function() {
	var base = Locus.configuration.apiURL;
	var configuration = this.getWidget().getConfiguration();
	var plugin = configuration.plugin;
	var urlParameters = new Array();
	urlParameters.push(plugin + '[controller]=' + configuration.controller);
	urlParameters.push(plugin + '[action]=' + configuration.action);
	return base + '&' + urlParameters.join('&');
};

Dk_Wildside_Net_Request.prototype.setWidget = function(widget) {
	this.widget = widget;
};

Dk_Wildside_Net_Request.prototype.getWidget = function(widget) {
	return this.widget;
};

Dk_Wildside_Net_Request.prototype.setAjax = function(ajaxObject) {
	this.ajax = ajaxObject;
	return this;
};

Dk_Wildside_Net_Request.prototype.getAjax = function() {
	return this.ajax;
};
