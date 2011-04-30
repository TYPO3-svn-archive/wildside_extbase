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

class Tx_WildsideExtbase_ViewHelpers_Map_TableViewHelper extends Tx_WildsideExtbase_ViewHelpers_TableViewHelper {
	
	/**
	 * Render method
	 * 
	 * @param int $cellspacing
	 * @param int $cellpadding
	 * @param string $iconAsc Icon file for ASC order indication
	 * @param string $iconDesc Icon file for DESC order indication
	 * @param string $iconDefault Icon file for sorting indication
	 * @param string $textExtraction Which method to use for text extraction. Valid values are "simple", "compex" or string name of a Javascript function you created
	 * @param array $data If specified, renders array $data as table rows using keys for headers
	 * @param array $headers If specified, uses $headers as array of header names
	 * @param array $objects If specified, considers $object an array of DomainObjects or associative arrays. If !$properties and !$annotationName then all properties are rendered
	 * @param array $properties If specified, uses array $properties as list of properties on each object to render as a row
	 * @param string $annotationName If specified, source code annotation (for example @myannotation) is used to determine which object properties to render as a row
	 * @param string $annotationValue If specified, source code annotation $annotationName must have $annotationValue as one of its listed attributes (for example @myannotation value1 value2 matches $annotationValue='value1' and $annotationValue='value2')
	 * @return string
	 */
	public function render(
			$cellspacing=FALSE, 
			$cellpadding=FALSE, 
			$iconAsc=FALSE, 
			$iconDesc=FALSE, 
			$iconDefault=FALSE, 
			$textExtraction='simple',
			array $data=NULL,
			array $headers=NULL,
			array $objects=NULL,
			array $properties=NULL,
			$annotationName=NULL,
			$annotationValue=NULL) {
		$this->rowClassPrefix = 'marker';
		parent::render($cellspacing, $cellpadding, $iconAsc, $iconDesc, $iconDefault, $textExtraction, $data, $headers, $objects, $properties, $annotationName, $annotationValue);
		$this->tag->addAttribute('class', 'wildside-extbase-sortable wildside-extbase-maplist');
		if ($objects || $data) {
			return $this->tag->render();
		}
		$layers = $this->templateVariableContainer->get('layers');
		$rows = "";
		
		foreach ($layers as $layer) {
			foreach ($layer as $marker) {
				$data = $marker['data'];
				$rows .= "<tr class='{$this->rowClassPrefix}{$marker['id']}'>";
				foreach ($data as $name=>$value) {
					$rows .= "<td class='{$name}'>{$value}</td>";
				}
				$rows .= "</tr>";
			}
		}
		$first = array_shift(array_shift($layers));
		$keys = array_keys($first['data']);
		$head = "";
		foreach ($keys as $name=>$key) {
			$head .= "<th class='{$name}'>{$key}</th>";
		}
		
		$html = "<thead>
<tr>
	{$head}
</tr>
</thead>
<tbody>
{$rows}
</tbody>";

		$this->tag->setContent($html);
		return $this->tag->render();
	}
}
	
?>