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
 * Test for databackendConfiguration factory
 *
 * @package Typo3
 * @subpackage pt_extlist
 * @author Daniel Lienert 
 */
class Tx_PtExtlist_Tests_Domain_Configuration_DataBackend_DataBackendConfigurationFactoryTest extends Tx_Extbase_BaseTestcase {
	
	public function testGetInstance() {
		$configurationBuilder = Tx_PtExtlist_Tests_Domain_Configuration_ConfigurationBuilderMock::getInstance();
		$dataBackendConfig = Tx_PtExtlist_Domain_Configuration_DataBackend_DataBackendConfigurationFactory::getInstance($configurationBuilder);
		$this->assertTrue(is_a($dataBackendConfig, 'Tx_PtExtlist_Domain_Configuration_DataBackend_DatabackendConfiguration'));
	}
	
}
?>