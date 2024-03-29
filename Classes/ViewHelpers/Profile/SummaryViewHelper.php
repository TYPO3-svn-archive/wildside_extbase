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

class Tx_WildsideExtbase_ViewHelpers_Profile_SummaryViewHelper extends Tx_WildsideExtbase_Core_ViewHelper_AbstractViewHelper {
	
	
	/**
	 * 
	 * @return string
	 */
	public function render() {
		$profile =& $GLOBALS['wildide_extbase_profile'];
		$totalDuration = 0;
		foreach ($profile['ticks'] as $k=>$tick) {
			$duration = str_replace(',', '', $tick['duration']);
			$totalDuration += $duration;
		}
		foreach ($profile['ticks'] as $k=>$tick) {
			$duration = str_replace(',', '', $tick['duration']);
			$percentage = ceil(($duration / $totalDuration) * 100);
			$profile['ticks'][$k]['percentage'] = $percentage;
			$allPercent += $percentage;
		}
		
		if ($allPercent > 100) {
			$diff = $allPercent - 100;
			$profile['ticks'][$k]['percentage'] -= $diff; 
		} else if ($allPercent < 100) {
			$diff = 100 - $allPercent;
			$profile['ticks'][$k]['percentage'] += $diff;
		}
		
		$templateFile = t3lib_extMgm::extPath('wildside_extbase', 'Resources/Private/Templates/Profile/Summary.html');
		$template = $this->getTemplate($templateFile);
		$template->assign('profile', $profile);
		$template->assign('totalDuration', $totalDuration);
		
		return $template->render();
	}
}

?>