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
 * Testcase for pt_list typo3 data backend object. 
 * 
 * @author Michael Knoll <knoll@punkt.de>
 * @package Typo3
 * @subpackage pt_extlist
 */
class Tx_PtExtlist_Tests_Domain_DataBackend_Typo3DataBackend_Typo3DataBackend_testcase extends Tx_PtExtlist_Tests_Domain_DataBackend_AbstractDataBackendBaseTest {

	protected $tsConfigString =
"plugin.tx_ptextlist.settings {

    # This comes from flexform!
    listIdentifier = list1

    listConfig.list1 {
    
        # config f�r dosGenerator
        backendConfig {

            dataBackendClass = Tx_PtExtlist_Domain_DataBackend_Typo3DataBackend_Typo3DataBackend
            dataMapperClass = Tx_PtExtlist_Domain_DataBackend_Mapper_ArrayMapper
            
            datasource {

            }
            
            tables (
                static_countries, 
                static_territories st_continent, 
                static_territories st_subcontinent
            )
            
            baseFromClause (
                ...
            )
            
            baseWhereClause (
                ...
            ) 
            
        }
}";
	
	
	
	public function testSetUp() {
		$this->assertTrue(class_exists('Tx_PtExtlist_Domain_DataBackend_Typo3DataBackend_Typo3DataBackend'));
	}
	
	
	
	public function testCreateDataSource() {
		$dataSource = Tx_PtExtlist_Domain_DataBackend_Typo3DataBackend_Typo3DataBackend::createDataSource($this->configurationBuilder);
		$this->assertTrue(is_a($dataSource, 'Tx_PtExtlist_Domain_DataBackend_DataSource_Typo3DataSource'));
	}
	
}

?>