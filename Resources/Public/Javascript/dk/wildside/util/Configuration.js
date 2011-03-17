

dk.wildside.util.Configuration = {
	
	// Bootstrapper. Override to use your own bootstrapper
	bootstrapper : 'dk.wildside.core.Bootstrap',
	
	// Debug tracing. Enable this to get console (firebug) output traces from the framework
	traceEnabled : true,
	
	// Selector names for objects. These are used by the entire system to add/remove and target
	// classnames on objects
	guiSelectors : {
		bootstrapConfiguration: ".settings > .setting",
		alohaRule : "wildside-extbase-aloha-rule",
		json : "wildside-extbase-json",
		widget : "wildside-extbase-widget",
		component : "wildside-extbase-component",
		inUse : "wildside-extbase--inuse",
		jsParent : "wildside-extbase--jsParent",
		instantiationFail : "wildside-extbase--instantiationFail",
		jQueryDataName : "wsExtBaseData",
		messageDisplayElement : "wildside-extbase-messages",
		messageClassInfo : "info",
		messageClassError : "error",
		itemParentLookup : ".plan.item"
	}

};