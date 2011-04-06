<?php 









class Tx_WildsideExtbase_Utility_PDF {
	
	
	public function run() {
		$post = $_POST['tx_wildsideextbase_pdf'];
		$source = $post['html'];
		$stylesheet = $post['stylesheet'];
		$filename = $post['filename'];
		$pdf = $this->grabPDF($source);
		header("Content-type: application/pdf");
		header("Content-Length: " . strlen($pdf));
		header("Content-disposition: attachment; filename={$filename}");
		echo $pdf;
		exit();
	}
	
	private function grabPDF($source) {
		// place the source code as a temporary file, then request it through HTTP
		// source contains the computed source as viewed by the browser; the 
		// most realistic representation possible. When used with the corresponding
		// widget, this allows injection of a stylesheet into the computed source,
		// allowing for style overrides when PDF-"printing".
		// The temp file is necessary because WebKit supports JS and even AJAX - 
		// and AJAX requires a security context, meaning an HTTP request.
		$source = stripslashes($source);
		$tmp = tempnam(PATH_site . 'typo3temp/', 'wspdfhtml');
		file_put_contents($tmp, $source);
		$cmd = $this->buildCommand('http://' . $_SERVER['HTTP_HOST'] . str_replace(PATH_site, '/', $tmp));
		$output = shell_exec($cmd);
		unlink($tmp);
		return $output;
	}
	
	/**
	 * Generate the command to run.
	 * @param $url string: the URL to open.
	 * @param $outputFile string: path and filename for output file.
	 * @return string Command string
	 */
	public function buildCommand($url) {
			
		$cmd = t3lib_extMgm::extPath('wildside_extbase', 'Resources/Shell/wkhtmltopdf');
		
		# Footers
		if (strlen($this->footerRight)) $cmd .= " --footer-right \"{$this->footerRight}\"";
		if (strlen($this->footerLeft)) $cmd .= " --footer-left \"{$this->footerLeft}\"";

		# Margins
		if (strlen($this->marginTop)) $cmd .= " --margin-top {$this->marginTop}";
		if (strlen($this->marginRight)) $cmd .= " --margin-right {$this->marginRight}";
		if (strlen($this->marginBottom)) $cmd .= " --margin-bottom {$this->marginBottom}";
		if (strlen($this->marginLeft)) $cmd .= " --margin-left {$this->marginLeft}";
		
		# user style sheet
		if (strlen($this->stylesheet)) $cmd .= " --user-stylesheet {$this->stylesheet}";
		
		# Target URL
		$cmd .= " \"{$url}\"";
		
		# Output file
		$cmd .= " - ";
		
		return $cmd;
	}
	
}


?>