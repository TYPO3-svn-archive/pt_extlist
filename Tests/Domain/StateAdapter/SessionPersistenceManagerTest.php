<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011 punkt.de GmbH - Karlsruhe, Germany - http://www.punkt.de
 *  Authors: Daniel Lienert, Michael Knoll, Christoph Ehscheidt
 *  All rights reserved
 *
 *  For further information: http://extlist.punkt.de <extlist@punkt.de>
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
 * Testcase for session persistence manager
 *
 * @package Tests
 * @subpackage Domain\StateAtadapter
 * @author Michael Knoll 
 * @author Daniel Lienert 
 */
class Tx_PtExtlist_Tests_Domain_StateAdapter_SessionPersistenceManager_testcase extends Tx_PtExtlist_Tests_BaseTestcase {
	
	public function testSetup() {
		$sessionPersistenceManager = new Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManager();
	}
	
	
	
	public function testPersistToSession() {
		$persistableObjectStub = new Tx_PtExtlist_Tests_Domain_StateAdapter_Stubs_PersistableObject();
		$sessionPersistenceManager = Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManagerFactory::getInstance();
		$sessionPersistenceManager->persistToSession($persistableObjectStub);
	}
	
	
	
	public function testReloadFromSession() {
		$persistableObjectStub = new Tx_PtExtlist_Tests_Domain_StateAdapter_Stubs_PersistableObject();
        $sessionPersistenceManager = Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManagerFactory::getInstance();
        $persistableObjectStub->initSomeData();
        $sessionPersistenceManager->persistToSession($persistableObjectStub);
        
        $reloadedPersistableObject = new Tx_PtExtlist_Tests_Domain_StateAdapter_Stubs_PersistableObject();
        $sessionPersistenceManager->loadFromSession($reloadedPersistableObject);
        $this->assertTrue($reloadedPersistableObject->dummyData['testkey1'] == 'testvalue1');
	}
	
	
	
	public function testInjectSessionAdapter() {
		$sessionAdapter = tx_pttools_sessionStorageAdapter::getInstance();
		$sessionPersistenceManager = Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManagerFactory::getInstance();
		$sessionPersistenceManager->injectSessionAdapter($sessionAdapter);
	}
	
	
	
	public function testGetSessionDataByNamespace() {
		$returnArray = array('test1' => array('test2' => array('test3' => 'value')));
		
		$sessionAdapterMock = new Tx_PtExtlist_Tests_Domain_StateAdapter_Stubs_SessionAdapterMock();
		
		$sessionPersistenceManager = Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManagerFactory::getInstance();
        $sessionPersistenceManager->injectSessionAdapter($sessionAdapterMock);
        $sessionPersistenceManager->read();
        
		$this->assertEquals($sessionPersistenceManager->getSessionDataByNamespace('test1.test2.test3'), 'value');
	}
	
	
	
	public function testProcessBookmark() {
		/*
		 * Bookmarks are currently not working! 
		 * TODO: Fix them with new Session namespace
		 * 
		$sessionPersistenceManager = Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManagerFactory::getInstance();
		$bookmark = new Tx_PtExtlist_Domain_Model_Bookmarks_Bookmark();
		$bookmark->setContent(serialize(array('filters' => array('test' => 'value'))));
		$bookmark->setListId('test');
		$sessionPersistenceManager->processBookmark($bookmark);
		$this->assertEquals($sessionPersistenceManager->getSessionDataByNamespace('test.filters.test'), 'value');
		*/
	}
	
	
	
	/** @test */
	public function getSessionDataHash() {
		$sessionPersistenceManager = $this->getAccessibleMock('Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManager', array('dummyMethod'), array(),'',FALSE);
		$sessionPersistenceManager->_set('sessionData', array('test'));
		$hash = $sessionPersistenceManager->getSessionDataHash();
		
		$this->assertEquals(md5(serialize(array('test'))), $hash);
	}
	
}
?>