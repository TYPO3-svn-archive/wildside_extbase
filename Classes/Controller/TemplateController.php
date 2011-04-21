<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Claus Due <claus@wildside.dk>, Wildside A/S
*  
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 3 of the License, or
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


/**
 * Template Rendering Controller
 */
 class Tx_WildsideExtbase_Controller_TemplateController extends Tx_WildsideExtbase_Core_AbstractController {
 	
 	/**
 	 * Show template as defined in flexform
 	 * @return string
 	 */
 	public function showAction() {
 		$json = $this->objectManager->get('Tx_WildsideExtbase_Utility_JSON');
 		$flexform = $this->getFlexForm();
 		$view =& $this->view;
 		if ($flexform['templateFile']) {
			$view = $this->objectManager->get('Tx_Fluid_View_StandaloneView');
			$view->setTemplateSource(file_get_contents(PATH_site . $flexform['templateFile']));
		} else if ($flexform['templateSource']) {
			$view = $this->objectManager->get('Tx_Fluid_View_StandaloneView');
			$view->setTemplateSource($flexform['templateSource']);
		}
		if ($flexform['fluidVars']) {
			$object = $json->decode($flexform['fluidVars']);
			foreach ($object as $k=>$v) {
				$view->assign($k, $v);
			}
		}
		return $view->render();
 	}
 	
 }
 
 
 ?>