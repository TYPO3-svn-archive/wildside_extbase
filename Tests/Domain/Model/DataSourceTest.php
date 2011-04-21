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

/**
 * Testcase for class Tx_WildsideExtbase_Domain_Model_DataSource.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Wildside ExtBase Framework
 * 
 * @author Claus Due <claus@wildside.dk>
 */
class Tx_WildsideExtbase_Domain_Model_DataSourceTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_WildsideExtbase_Domain_Model_DataSource
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_WildsideExtbase_Domain_Model_DataSource();
	}

	public function tearDown() {
		unset($this->fixture);
	}
	
	
	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setNameForStringSetsName() { 
		$this->fixture->setName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getName()
		);
	}
	
	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() { 
		$this->fixture->setDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDescription()
		);
	}
	
	/**
	 * @test
	 */
	public function getQueryReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setQueryForStringSetsQuery() { 
		$this->fixture->setQuery('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getQuery()
		);
	}
	
	/**
	 * @test
	 */
	public function getFuncReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setFuncForStringSetsFunc() { 
		$this->fixture->setFunc('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getFunc()
		);
	}
	
	/**
	 * @test
	 */
	public function getUrlReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setUrlForStringSetsUrl() { 
		$this->fixture->setUrl('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getUrl()
		);
	}
	
	/**
	 * @test
	 */
	public function getUrlMethodReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setUrlMethodForStringSetsUrlMethod() { 
		$this->fixture->setUrlMethod('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getUrlMethod()
		);
	}
	
	/**
	 * @test
	 */
	public function getTemplateFileReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTemplateFileForStringSetsTemplateFile() { 
		$this->fixture->setTemplateFile('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTemplateFile()
		);
	}
	
	/**
	 * @test
	 */
	public function getTemplateSourceReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTemplateSourceForStringSetsTemplateSource() { 
		$this->fixture->setTemplateSource('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTemplateSource()
		);
	}
	
}
?>