<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <lienert@punkt.de>, Michael Knoll <knoll@punkt.de>
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
 * Testcase for abstract configuration builder class
 *
 * @package Tests
 * @subpackage Domain\Configuration
 * @author Michael Knoll <knoll@punkt.de>
 */
class Tx_PtExtlist_Tests_Domain_Configuration_AbstractConfigurationBuilderTest extends Tx_PtExtlist_Tests_BaseTestcase {

	/**
	 * Holds an array of settings for testing
	 *
	 * @var array
	 */
	protected $settings = array('testKey' => array('key1' => 'value1'));
	
	
	
	/**
	 * Holds a dummy implementation of abstract configuration builder for testing
	 *
	 * @var Tx_PtExtlist_Tests_Domain_Configuration_AbstractConfigurationBuilder_Stub
	 */
	protected $fixture;
	
	
	
	/** @test */
	public function setUp() {
		$this->fixture = new Tx_PtExtlist_Tests_Domain_Configuration_AbstractConfigurationBuilder_Stub($this->settings);
	}
	
	
	
	/** @test */
	public function genericCallReturnsConfigurationObjectForGivenConfiguration() {
		$configurationObject = $this->fixture->buildDummyConfiguration();
		$this->assertTrue(is_a($configurationObject, 'Tx_PtExtlist_Tests_Domain_Configuration_DummyConfigurationObject'));
		$this->assertEquals($configurationObject->getSettings(), $this->settings['testKey']);
	}
	
}



/**
 * Concrete implementation of abstract configuration builder for testing
 */
require_once t3lib_extMgm::extPath('pt_extlist') . 'Classes/Domain/Configuration/AbstractConfigurationBuilder.php';
class Tx_PtExtlist_Tests_Domain_Configuration_AbstractConfigurationBuilder_Stub extends Tx_PtExtlist_Domain_Configuration_AbstractConfigurationBuilder {
	
    protected $configurationObjectSettings = array(
        'dummy' => array(
            'factory' => 'Tx_PtExtlist_Tests_Domain_Configuration_AbstractConfigurationBuilder_DummyConfigurationObjectFactory',   
        )
    );

    public function getListIdentifier() {
    	return 'test';
    }
	
}





require_once t3lib_extMgm::extPath('pt_extlist') . 'Classes/Domain/Configuration/AbstractConfiguration.php';
class Tx_PtExtlist_Tests_Domain_Configuration_DummyConfigurationObject extends Tx_PtExtlist_Domain_Configuration_AbstractConfiguration  {
	
}






class Tx_PtExtlist_Tests_Domain_Configuration_AbstractConfigurationBuilder_DummyConfigurationObjectfactory {
	public function getInstance(Tx_PtExtlist_Tests_Domain_Configuration_AbstractConfigurationBuilder_Stub $configurationBuilder) {
		$configObject = new Tx_PtExtlist_Tests_Domain_Configuration_DummyConfigurationObject($configurationBuilder, array('key1' => 'value1'));
		return $configObject;
	}
}


?>