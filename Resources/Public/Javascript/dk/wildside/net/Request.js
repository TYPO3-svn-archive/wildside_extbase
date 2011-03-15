dk.wildside.net.Request = function(widget, action) {
	this.ajax = false;
	this.setWidget(widget);
	if (typeof(action) != 'undefined') {
		this.action = 'update';
	} else {
		this.action = this.widget.getConfiguration().action;
	};
};

dk.wildside.net.Request.prototype.getScope = function() {
	var configuration = this.getWidget().getConfiguration();
	var plugin = configuration.plugin;
	return plugin;
};

dk.wildside.net.Request.prototype.getUrl = function() {
	//var base = Locus.configuration.apiURL;
	var configuration = this.getWidget().getConfiguration();
	var base = configuration.api;
	var plugin = configuration.plugin;
	var urlParameters = new Array();
	urlParameters.push(plugin + '[controller]=' + configuration.controller);
	urlParameters.push(plugin + '[action]=' + configuration.action);
	return base + '&' + urlParameters.join('&');
};

dk.wildside.net.Request.prototype.setWidget = function(widget) {
	this.widget = widget;
};

dk.wildside.net.Request.prototype.getWidget = function(widget) {
	return this.widget;
};

dk.wildside.net.Request.prototype.setAjax = function(ajaxObject) {
	this.ajax = ajaxObject;
	return this;
};

dk.wildside.net.Request.prototype.getAjax = function() {
	return this.ajax;
};
