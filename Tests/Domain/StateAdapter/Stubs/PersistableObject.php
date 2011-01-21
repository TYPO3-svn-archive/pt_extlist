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
 * Dummy class implementing session persistable object interface.
 *
 * @package TYPO3
 * @subpackage pt_extlist
 */
class Tx_PtExtlist_Tests_Domain_StateAdapter_Stubs_PersistableObject implements Tx_PtExtlist_Domain_StateAdapter_SessionPersistableInterface {
	
	/**
	 * Some dummy data to be stored in session
	 *
	 * @var array
	 */
	public $dummyData = array();
	
	
	
	/**
	 * Fake method to initialize some dummy data
	 * 
	 * @return void
	 */
	public function initSomeData() {
		$this->dummyData = array('testkey1' => 'testvalue1', 'testkey2' => 'testvalue2');
	}
	
	
	
	/**
	 * Function called by session persistence handler to retrieve data to be stored in session
	 *
	 * @return array Object data to be stored in session
	 */
	public function persistToSession() {
		return $this->dummyData;
	}
    
	
	
	/**
	 * Returns namespace of object to store data in session with
	 *
	 * @return String Namespace as key to store session data with
	 */
    public function getObjectNamespace() {
    	return 'tests.stateadapter.stubs.persistableobject';
    }
    
    
    
    /**
     * Function called by session persistence handler, when object needs to be restored from session
     *
     * @param array $sessionData
     */
    public function injectSessionData(array $sessionData) {
    	$this->dummyData = $sessionData;
    }
}

?>