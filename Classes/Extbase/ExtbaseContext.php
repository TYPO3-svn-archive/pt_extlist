<?php
/***************************************************************
* Copyright notice
*
*   2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
* All rights reserved
*
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
* Holds the extbaseContext of the current plugin instance
*
* @package Extbase
* @author Daniel Lienert
*/

class Tx_PtExtlist_Extbase_ExtbaseContext implements t3lib_Singleton {

	/**
	 * @var Tx_Extbase_MVC_Controller_ControllerContext
	 */
	protected $controllerContext;
	
	
	/**
	 * @var bool isInCachedMode
	 */
	protected $isInCachedMode = false;
	
	
	/**
	 * @var string;
	 */
	protected $sessionStorageMode;
	
	
	/**
	 * Namepsace of current Extension
	 * 
	 * @var string
	 */
	protected $extensionName;
	
	
	/**
	 * @var string
	 */
	protected $extensionNameSpace;
	
	
	/**
	 * Flexform selected ListIdentifier
	 * @var string
	 */
	protected $currentListIdentifier;
	
	
	/**
	 * @var Tx_Extbase_Configuration_ConfigurationManager
	 */
	protected $configurationManager;
	
	
	/**
	 * Initialize the object (called by objectManager)
	 * 
	 */
	public function initializeObject() {
		$frameWorkKonfiguration = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		
		$this->extensionName = $frameWorkKonfiguration['extensionName'];
		$this->extensionNameSpace = Tx_Extbase_Utility_Extension::getPluginNamespace($frameWorkKonfiguration['extensionName'], 
																						$frameWorkKonfiguration['pluginName']); 
		
		$this->sessionStorageMode = $frameWorkKonfiguration['pluginName'] == 'Cached' 
					? Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManager::STORAGE_ADAPTER_DB 
					: Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManager::STORAGE_ADAPTER_SESSION;
		
		$this->isInCachedMode = $frameWorkKonfiguration['pluginName'] == 'Cached' ? true : false;
					
		$this->useStateCache = true; // TODO make this configurable
		
		$this->currentListIdentifier = $frameWorkKonfiguration['settings']['listIdentifier'];
		
		unset($frameWorkKonfiguration);
	}
	
	
	
	/**
	 * @param Tx_Extbase_Configuration_ConfigurationManager $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManager $configurationManager) {
		$this->configurationManager = $configurationManager;
	}
	
	
	
	/**
	 * Set the Controller Context
	 * 
	 * @param Tx_Extbase_MVC_Controller_ControllerContext $controllerContext
	 */
	public function setControllerContext(Tx_Extbase_MVC_Controller_ControllerContext $controllerContext) {
		$this->controllerContext = $controllerContext;
	}
	
	
	
	/**
	 * @return Tx_Extbase_MVC_Controller_ControllerContext $controllerContext
	 */
	public function getControllerContext() {
		return $this->controllerContext;
	}
	
	
	
	/**
	 * @return string constant
	 */
	public function getSessionStorageMode() {
		return $this->sessionStorageMode;
	}
	
	
	/**
	 * @return bool
	 */
	public function isInCachedMode() {
		return $this->isInCachedMode;
	}
	
	
	
	/**
	 * @param bool $isInCachedMode
	 */
	public function setInCachedMode($isInCachedMode) {
		$this->isInCachedMode = $isInCachedMode;
	}
	
	
	
	/**
	 * Set the cached mode for the complete extension.
	 * This is autmatically set when extlsit is used as standalone extension
	 * 
	 * @param string $sessionStorageMode
	 */
	public function setSessionStorageMode($sessionStorageMode) {
		$this->sessionStorageMode = $sessionStorageMode;
	}
	
	
	
	/**
	 * @return bool
	 */
	public function useStateCache() {
		return $this->useStateCache;
	}
	
	
	
	/**
	 * @return string
	 */
	public function getExtensionNamespace() {
		return $this->extensionNameSpace;
	}
	
	
	
	/**
	 * @return string
	 */
	public function getCurrentListIdentifier() {
		return $this->currentListIdentifier;
	}
	
	
	
	/**
	 * @return string
	 */
	public function getExtensionName() {
		return $this->extensionName;
	}
	
}
?>