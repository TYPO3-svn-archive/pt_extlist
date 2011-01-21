<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert , Michael Knoll 
*  All rights reserved
*
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
 * Class implements testcase for export configuration factory
 *
 * @package Tests
 * @subpackage Domain\Configuration\Export
 * @author Daniel Lienert 
 */
class Tx_PtExtlist_Tests_Domain_Configuration_Export_ExportConfigFactory_testcase extends Tx_PtExtlist_Tests_BaseTestcase {

	
	public function setup() {
		$this->initDefaultConfigurationBuilderMock();
	}
		
	
	
	public function testSetup() {
		$this->assertTrue(class_exists('Tx_PtExtlist_Domain_Configuration_Export_ExportConfigFactory'));
	}
	
	
	public function testGetInstance() {
		$exportConfigInstance = Tx_PtExtlist_Domain_Configuration_Export_ExportConfigFactory::getInstance($this->configurationBuilderMock);
		$this->assertTrue(is_a($exportConfigInstance, 'Tx_PtExtlist_Domain_Configuration_Export_ExportConfig'));
	}
	
}	
?>