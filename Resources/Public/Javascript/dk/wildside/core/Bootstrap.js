dk.wildside.core.Bootstrap = function() {
	this.registeredComponents = new dk.wildside.util.Iterator();
	this.registeredWidgets = new dk.wildside.util.Iterator();
};

dk.wildside.core.Bootstrap.prototype.run = function() {
	
	dk.wildside.bootstrap = this;
	
	// Find the settings-div, which is somewhere near the top of the page, and read all global settings
	// from it. These will be stored in the global object Locus.configuration.
	jQuery(dk.wildside.util.Configuration.guiSelectors.bootstrapConfiguration).each(function(){
		var setting = jQuery(this);
		var key = setting.attr("title");
		var value = setting.html().trim();
		dk.wildside.util.Configuration[key] = value;
	});
	
	// Now, bootstrap all existing components on the page. This automatically handles
	// any sub-widgets found in there too.
	jQuery("." + dk.wildside.util.Configuration.guiSelectors.component).each( function() {
		//dk.wildside.bootstrap.bootstrapComponent(this);
		var component = new dk.wildside.display.Component(this);
	});
	
	// Now, if any widgets are left untouched, we need to bootstrap them as standalones
	jQuery("." + dk.wildside.util.Configuration.guiSelectors.widget +":not(." + dk.wildside.util.Configuration.guiSelectors.inUse +")").each( function() {
		//dk.wildside.bootstrap.bootstrapWidget(this);
		var widget = new dk.wildside.display.widget.Widget(this);
	} );
	
	// Basic configuration - this can be overruled later, though.
	var editConfig = { };
	jQuery("." + dk.wildside.util.Configuration.guiSelectors.alohaRule).each(function(){
		var t = jQuery(this);
		var key = t.attr("title");
		var val = t.text().trim().split(",");
		editConfig[key] = val;
	});
	
	// Subscribe to the edit-finish event on all existing (and future) Aloha-instances.
	GENTICS.Aloha.EventRegistry.subscribe(GENTICS.Aloha, "editableDeactivated", function(event, eventProperties) {
		var aloha = eventProperties.editable;
		if (aloha.isModified()) {
			// Reset modification, Widget now takes over
			aloha.setUnmodified();
			// Get the associated widget and mark as dirty
			var obj = jQuery(aloha.obj);
			var widget = obj.data("widget");
			if (!widget) {
				widget = obj.data('field').getParent();
			};
			widget.markDirty.call(widget);
		};
	});
};

/*
dk.wildside.core.Bootstrap.prototype.bootstrapComponent = function(element) {
	var component = new dk.wildside.display.Component(element);
};

dk.wildside.core.Bootstrap.prototype.bootstrapWidget = function(element) {
	var widget = new dk.wildside.display.widget.Widget(element);
};
*/