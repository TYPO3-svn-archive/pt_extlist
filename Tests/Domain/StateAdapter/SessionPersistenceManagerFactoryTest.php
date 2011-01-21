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
 * 
 *
 * @package TYPO3
 * @subpackage pt_extlist
 */

class Tx_PtExtlist_Tests_Domain_StateAdapter_SessionPersistenceManagerFactory_testcase extends Tx_Extbase_BaseTestcase {
	
	/**
	 * Test for existence of class
	 */
	public function testSetup() {
		$this->assertTrue(class_exists('Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManagerFactory'));
	}

	
	
	/**
	 * Test whether returned instance is singleton
	 */
	public function testSingletonInstance() {
		$firstInstance = Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManagerFactory::getInstance();
		$secondInstance = Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManagerFactory::getInstance();
		$this->assertTrue($firstInstance == $secondInstance);
	}
}



?>