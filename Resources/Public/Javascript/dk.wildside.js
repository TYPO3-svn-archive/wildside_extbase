
if (typeof dk == 'undefined') {
	dk = {};
};

if (typeof dk.wildside == 'undefined') {
	dk.wildside = {};
	dk.wildside.bootstrap = {};
	dk.wildside.core = {};
	dk.wildside.display = {};
	dk.wildside.display.widget = {};
	dk.wildside.display.field = {};
	dk.wildside.display.component = {};
	dk.wildside.event = {};
	dk.wildside.event.widget = {};
	dk.wildside.net = {};
	dk.wildside.util = {};
};

jQuery(document).ready(function() {
	eval('var bootstrap = new ' + dk.wildside.util.Configuration.bootstrapper + '();');
	bootstrap.run();
});

// util/String.js
// util/Iterator.js
// util/Configuration.js
// net/Request.js
// net/Response.js
// net/Responder.js
// net/Dispatcher.js
// event/Event.js
// event/MouseEvent.js
// event/EventDispatcher.js
// event/widget/WidgetEvent.js
// event/widget/FileUploadEvent.js
// event/widget/RecordSelectorEvent.js
// display/DisplayObject.js
// display/Control.js
// display/Component.js
// display/field/Field.js
// display/field/Input.js
// display/field/Checkbox.js
// display/field/Radio.js
// display/field/Select.js
// display/field/Button.js
// display/field/Textarea.js
// display/widget/Widget.js
// display/widget/FileUploadWidget.js
// display/widget/RecordSelectorWidget.js
// core/Bootstrap.js