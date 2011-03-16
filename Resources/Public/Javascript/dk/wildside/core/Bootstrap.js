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
		dk.wildside.bootstrap.bootstrapComponent(this);
	});
	
	// Now, if any widgets are left untouched, we need to bootstrap them as standalones
	jQuery("." + dk.wildside.util.Configuration.guiSelectors.widget +":not(." + dk.wildside.util.Configuration.guiSelectors.inUse +")").each( function() {
		dk.wildside.bootstrap.bootstrapWidget(this);
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
			jQuery(aloha.obj).data("widget").markDirty();
		};
	});
};









// TODO: move this to Component constructor
dk.wildside.core.Bootstrap.prototype.bootstrapComponent = function(element) {
	// Setup component, based on its class, and store for later use
	var obj = jQuery(element);
	var componentObject = false;
	var json = jQuery.parseJSON(obj.find("> ." + dk.wildside.util.Configuration.guiSelectors.json).text().trim());
	var componentType = json.component;
	eval("if (typeof(" + componentType + ") == 'function') componentObject = new " + componentType + "(obj);");
	// If we made a component instantiation, now's the time to register the widgets inside it.
	if (componentObject) {
		// Find all immediate widgets anywhere in the subtree, but NOT if they're preceded by a new component section.
		// We only want children of this specific component, wherever they may be. Or roam. That's a Metallica song, btw.
		var parent = this;
		obj.find("." + dk.wildside.util.Configuration.guiSelectors.widget +":not(." + dk.wildside.util.Configuration.guiSelectors.inUse +")").not(obj.find("." + dk.wildside.util.Configuration.guiSelectors.component +" ." + dk.wildside.util.Configuration.guiSelectors.widget)).each( function() {
			parent.bootstrapWidget(this, componentObject);
		});
		// Push the new component into the registeredComponents-heap.
		this.registeredComponents.push(componentObject);
	};
};

// TODO: move this to Widget constructor
dk.wildside.core.Bootstrap.prototype.bootstrapWidget = function(element, component) {
	var widgetobj = jQuery(element);
	var widget = false;
	var json = jQuery.parseJSON(widgetobj.find("> ." + dk.wildside.util.Configuration.guiSelectors.json).text().trim());
	var widgetType = json.widget;
	eval("if (typeof(" + widgetType + ") != 'undefined') widget = new " + widgetType + "(widgetobj);");
	if (!widget) {
		try {
			widgetobj.addClass(dk.wildside.util.Configuration.guiSelectors.instantiationFail);
			console.info(element);
			console.warn("Javascript widget class " + widgetType + " does not exist!");
		} catch (e) {};
	};
	if (widget && component) {
		component.registerWidget(widget);
		this.registeredWidgets.push(widget);
	}
	// Instantiate Aloha objects on the widget. As you can, like, totally see, we distinguish
	// between content, titles and stuff.
	widgetobj.find(".text-content.aloha").data("widget", widget).aloha();
	widgetobj.find(".text-title.aloha").data("widget", widget).aloha();
};