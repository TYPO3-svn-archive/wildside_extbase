<?php 




class Tx_WildsideExtbase_ViewHelpers_Widget_TimelineViewHelper extends Tx_WildsideExtbase_ViewHelpers_WidgetViewHelper {
	
	
	/**
	 * 
	 * @param array $objects
	 */
	public function render($objects) {
		
		$json = array();
		$config = new stdClass();
		$config->id = 'jshist';
		$config->title = 'Timeline';
		$config->focus_date = date('Y-m-d H:i:s');
		$config->initial_zoom = 20;
		$config->events = array();
		
		foreach ($objects as $object) {
			$time = $object->getTstamp();
			$date = date('Y-m-d H:i:s', $time);
			$item = new stdClass();
			$item->id = 'jshist-'.$object->getUid();
			$item->title = $object->getTitle();
			$item->description = $object->getDescription();
			$item->startdate = $date;
			$item->enddate = $date;
			$item->link = '';
			$item->importance = 40;
			$item->icon = '';
			array_push($config->events, $item);
		}
		
		array_push($json, $config);
		
		$temp = json_encode($json);
		$md5 = md5($temp);
		
		$tempJSON = PATH_site . '/typo3temp/'. $md5 . '.json';
		file_put_contents($tempJSON, $temp);
		$children = $this->renderChildren();
		$html = <<< HTML
<div id='timeline' style="width: 500px; height: 300px;"></div>

<div class='controls'>
<table>
<tr><td id='zoomlevel' width='33%'>...</td><td id='tickwidth' width='33%'>tw</td><td id='focusdate'>...</td></tr>
<tr><td id='tickpos'></td><td colspan='2' id='note'>...</td></tr>
</table>
</div>

{$children}
HTML;
		
		$script = <<< SCRIPT
jQuery(document).ready(function () {
	var glider = jQuery("#timeline").timeline({
	"min_zoom":20,
	"max_zoom":70,
	"initial_timeline_id": "jshist",
	"data_source":"/typo3temp/{$md5}.json"
	});
});

SCRIPT;
		
		$relPath = t3lib_extMgm::siteRelPath('wildside_extbase');
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		
		
		$injector = $objectManager->get('Tx_WildsideExtbase_ViewHelpers_Inject_CssViewHelper');
		$injector->render(NULL, $relPath . 'Resources/Public/Javascript/com/timeglider/jquery-ui-1.8.5.custom.css');
		$injector->render(NULL, $relPath . 'Resources/Public/Stylesheet/Timeglider.css');
		
		$injector = $objectManager->get('Tx_WildsideExtbase_ViewHelpers_Inject_JsViewHelper');
		$injector->render($script);
		$injector->render(NULL, $relPath . 'Resources/Public/Javascript/com/timeglider/jquery-ui-1.8.9.custom.min.js');
		$injector->render(NULL, $relPath . 'Resources/Public/Javascript/com/timeglider/timeglider-0.0.7.min.js');
		return $html;
		
	}
	
}


?>