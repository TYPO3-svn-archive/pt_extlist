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
 * Class implements a factory for session persistence manager.
 *
 * @package Domain
 * @subpackage StateAdapter
 * @author Michael Knoll 
 * @author Daniel Lienert
 */
class Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManagerFactory {
	

	
	/**
	 * Singleton instance of session persistence manager object
	 *
	 * @var Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManager
	 */
	private static $instance;
	
	
	
	/**
	 * Factory method for session persistence manager 
	 * 
	 * @return Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManager Singleton instance of session persistence manager 
	 */
	public static function getInstance($sessionStorageMode = NULL) {
		if (self::$instance == NULL) {
			self::$instance = new Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManager();
			self::$instance->injectSessionAdapter(self::getStorageAdapter($sessionStorageMode));
			self::$instance->setSessionStorageMode($sessionStorageMode);
		}
		return self::$instance;
	}
	
	
	
	/**
	 * Initialize the sessionAdapter
	 *
	 * @return tx_pttools_iStorageAdapter storageAdapter
	 */
	private static function getStorageAdapter($storageMode) {
		
		switch($storageMode) {
			case Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManager::STORAGE_ADAPTER_SESSION:
				return tx_pttools_sessionStorageAdapter::getInstance();
				break;
			case Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManager::STORAGE_ADAPTER_DB:
				return Tx_PtExtlist_Domain_StateAdapter_Storage_DBStorageAdapterFactory::getInstance();
				break;
			case Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManager::STORAGE_ADAPTER_NULL:
				return new Tx_PtExtlist_Domain_StateAdapter_Storage_NullStorageAdapter();	
				break;
			default:
				return tx_pttools_sessionStorageAdapter::getInstance();
		}
	}
}
?>