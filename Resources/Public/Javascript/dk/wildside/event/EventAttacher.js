
dk.wildside.event.EventAttacher = {
	
	attachEvents : function(ev, jQueryElement) {
		
	},
	
	detachEvents : function(ev, jQueryElement) {
		
	},
	
	attachEvent : function(ev, jQueryElement) {
		
		switch (ev) {
			case "change":     jQueryElement.change(    dk.wildside.event.EventAttacher.__eventHandler); break;
			case "click":      jQueryElement.click(     dk.wildside.event.EventAttacher.__eventHandler); break;
			case "keydown":    jQueryElement.keydown(   dk.wildside.event.EventAttacher.__eventHandler); break;
			case "keyup":      jQueryElement.keyup(     dk.wildside.event.EventAttacher.__eventHandler); break;
			case "keypress":   jQueryElement.keypress(  dk.wildside.event.EventAttacher.__eventHandler); break;
			case "focus":      jQueryElement.focus(     dk.wildside.event.EventAttacher.__eventHandler); break;
			case "blur":       jQueryElement.blur(      dk.wildside.event.EventAttacher.__eventHandler); break;
			case "mouseover":  jQueryElement.mouseover( dk.wildside.event.EventAttacher.__eventHandler); break;
			case "mouseout":   jQueryElement.mouseout(  dk.wildside.event.EventAttacher.__eventHandler); break;
			case "mousemove":  jQueryElement.mousemove( dk.wildside.event.EventAttacher.__eventHandler); break;
			case "mouseenter": jQueryElement.mouseenter(dk.wildside.event.EventAttacher.__eventHandler); break;
			case "mouseleave": jQueryElement.mouseleave(dk.wildside.event.EventAttacher.__eventHandler); break;
			case "mouseup":    jQueryElement.mouseup(   dk.wildside.event.EventAttacher.__eventHandler); break;
			case "mousedown":  jQueryElement.mousedown( dk.wildside.event.EventAttacher.__eventHandler); break;
			case "resize":     jQueryElement.resize(    dk.wildside.event.EventAttacher.__eventHandler); break;
			case "select":     jQueryElement.select(    dk.wildside.event.EventAttacher.__eventHandler); break;
			case "scroll":     jQueryElement.scroll(    dk.wildside.event.EventAttacher.__eventHandler); break;
			case "submit":     jQueryElement.submit(    dk.wildside.event.EventAttacher.__eventHandler); break;
		};
		
	},
	
	detachEvent : function(ev, jQueryElement) {
		jQueryElement.unbind(ev, jQueryElement);
	},
	
	__eventHandler : function(originalEvent) {
		var obj = jQuery(this).data(dk.wildside.util.Configuration.guiSelectors.jQueryDataName);
		obj.dispatchEvent.call(obj, originalEvent.type, null, originalEvent);
	}
	
};