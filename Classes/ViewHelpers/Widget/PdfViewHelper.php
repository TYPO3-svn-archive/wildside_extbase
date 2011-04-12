<?php 












class Tx_WildsideExtbase_ViewHelpers_Widget_PdfViewHelper extends Tx_WildsideExtbase_ViewHelpers_WidgetViewHelper {
	
	/**
	 * 
	 * @param int $typeNum
	 * @param string $extension
	 * @param string $stylesheet Optional extra stylesheet to load on PDF creation
	 * @param string $filename Optional filename of downloaded PDF. Default is print.pdf
	 * @param string $wkhtmltopdf Optional path of wkhtmltopdf binary - specify only if you need your own version
	 * @return string
	 */
	public function render(
			$typeNum=48151623420, 
			$extension='tx_wildsideextbase_pdf', 
			$stylesheet=NULL, 
			$filename='print.pdf',
			$wkhtmltopdf=NULL) {
		$uniqId = uniqid('wsRenderPageAsPdf');
		$code = <<< CODE
<form action='?type={$typeNum}' method='post' id='{$uniqId}' style='display: none'>
<input type='hidden' name='{$extension}[html]' value='' />
<input type='hidden' name='{$extension}[stylesheet]' value='{$stylesheet}' />
<input type='hidden' name='{$extension}[filename]' value='{$filename}' />
<input type='hidden' name='{$extension}[wkhtmltopdf]' value='{$wkhtmltopdf}' />
</form>
CODE;
		$script = <<< SCRIPT
function {$uniqId}() {
	var f = jQuery('#{$uniqId}');
	f.find('input[name="{$extension}[html]"]').val('<html><head>'+document.head.innerHTML+'</head><body>'+document.body.innerHTML+'</body></html>');
	return f.submit();
}
SCRIPT;
		
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$injector = $objectManager->get('Tx_WildsideExtbase_ViewHelpers_Inject_JsViewHelper');
		
		$injector->render($script);
		
		$html = $this->renderChildren();
		$html .= $code;
		$html = "<a href='javascript:;' class='wsExtBase_pdfLink' onclick='{$uniqId}();'>{$html}</a>";
		return $html; 
	}

	
	
}


?>