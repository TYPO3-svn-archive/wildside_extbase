<?php 
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Claus Due <claus@wildside.dk>, Wildside A/S
*  			
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

class Tx_WildsideExtbase_ViewHelpers_Profile_MeasureViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	
	
	/**
	 * Measures rendering time, memory usage and output time of child elements
	 * 
	 * @param boolean $inline If TRUE, the child node content is prepended with a short summary - if FALSE, a profile tick is stored with the measured info
	 * @param string $label Specify this to identify this particular Measurement
	 * @return string
	 */
	public function render($inline=TRUE, $label='Measurement') {
		
		$now = microtime(TRUE);
		$mem = memory_get_usage();
		
		$content = $this->renderChildren();
		
		$stop = microtime(TRUE);
		$memAfter = memory_get_usage();
		$length = strlen($content);
		
		$duration = number_format(($stop - $now) * 1000, 0);
		$memUsed = number_format(($memAfter - $mem) / 1024, 2, '.', ',');
		$size = number_format(strlen($content) / 1024, 2, '.', ',');
		
		$summary = "{$label}: {$duration} ms, {$size} KB content, {$memUsed} KB memory consumed.";
		
		if ($inline) {
			$info = "<div>{$summary}</div>";
			$content = "{$info}\n{$content}";
		}
		Tx_WildsideExtbase_ViewHelpers_Profile_TickViewHelper::render($summary, $inline, $duration);
		
		return $content;
	}
}

?>