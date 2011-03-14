Locus_Configuration = function() {
	this.controller = null;
	this.action = null;
	this.pageUid = null;
	this.extensionName = null;
	this.data = null;
};

Locus_Configuration.prototype.getController = function() {
	return this.controller;
};

Locus_Configuration.prototype.setController = function(controller) {
	this.controller = controller;
};

Locus_Configuration.prototype.getAction = function() {
	return this.action;
};

Locus_Configuration.prototype.setAction = function(action) {
	this.action = action;
};

Locus_Configuration.prototype.getPageUid = function() {
	return this.pageUid;
};

Locus_Configuration.prototype.setPageUid = function(pageUid) {
	this.pageUid = pageUid;
};

Locus_Configuration.prototype.getExtensionName = function() {
	return this.extensionName;
};

Locus_Configuration.prototype.setExtensionName = function(extensionName) {
	this.extensionName = extensionName;
};

Locus_Configuration.prototype.getData = function() {
	return this.data;
};

Locus_Configuration.prototype.setData = function(data) {
	this.data = data;
};

