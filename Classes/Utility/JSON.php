<?php 



class Tx_WildsideExtbase_Utility_JSON implements t3lib_Singleton {
	
	
	/**
	 * Detect the PHP version being used
	 * 
	 * @return float
	 */
	private function getPHPVersion() {
		$segments = explode('.', phpversion());
		$major = array_shift($segments);
		$minor = array_shift($segments);
		$num = "{$major}.{$minor}"; 
		$num = (float) $num;
		return $num;
	}
	
	/**
	 * Get encoding options depending on PHP version
	 * 
	 * @return int
	 */
	private function getEncodeOptions() {
		if ($this->getPHPVersion() >= 5.3) {
			return JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP;
		} else {
			return 0;
		}
	}
	
	
	/**
	 * Encode to working JSON depending on PHP version
	 *  
	 * @param mixed $source
	 * @param int $options
	 */
	public function encode($source) {
		$options = $this->getEncodeOptions();
		$str = json_encode($source, $options);
		return $str;
	}
	
	
	/**
	 * Decode to working JSON depending on PHP version
	 * 
	 * @param string $str
	 */
	public function decode($str) {
		$decoded = json_decode($str);
		return $decoded;
	}
	
	
}

?>