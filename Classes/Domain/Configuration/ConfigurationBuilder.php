<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert , Michael Knoll ,
*  Christoph Ehscheidt 
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
 * Class implements a Builder for all configurations required in pt_extlist.
 * 
 * @package Domain
 * @subpackage Configuration
 * 
 * @author Daniel Lienert 
 * @author Michael Knoll 
 * @author Christoph Ehscheidt 
 */
class Tx_PtExtlist_Domain_Configuration_ConfigurationBuilder extends Tx_PtExtlist_Domain_Configuration_AbstractConfigurationBuilder {
	
	/**
	 * Holds settings to build configuration objects
	 *
	 * @var array
	 */
	protected $configurationObjectSettings = array(
	    'aggregateData' => 
	    	array('factory' => 'Tx_PtExtlist_Domain_Configuration_Data_Aggregates_AggregateConfigCollectionFactory'),
	    'aggregateRows' => 
	    	array('factory' => 'Tx_PtExtlist_Domain_Configuration_Aggregates_AggregateRowConfigCollectionFactory'),
	    'bookmarks' =>
	    	array('factory' => 'Tx_PtExtlist_Domain_Configuration_Bookmarks_BookmarksConfigFactory',
	    		  'prototype' => 'bookmarks'),
	    'columns' => 
	    	array('factory' => 'Tx_PtExtlist_Domain_Configuration_Columns_ColumnConfigCollectionFactory'),
	    'dataBackend' =>
	    	array('factory' => 'Tx_PtExtlist_Domain_Configuration_DataBackend_DataBackendConfigurationFactory',
	    	      'tsKey' => 'backendConfig'),
	    'export' => 
	    	array('factory' => 'Tx_PtExtlist_Domain_Configuration_Export_ExportConfigFactory'),
	    'fields' =>
	    	array('factory' => 'Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfigCollectionFactory'),
	    'filter' =>
	    	array('factory' => 'Tx_PtExtlist_Domain_Configuration_Filters_FilterboxConfigCollectionFactory',
	    		  'tsKey' => 'filters'),
	    'list' =>
	    	array('factory' => 'Tx_PtExtlist_Domain_Configuration_List_ListConfigFactory',
	    		  'prototype' => 'list',
	    		  'tsKey' => NULL),
	    'listDefault' =>
	    	array('factory' => 'Tx_PtExtlist_Domain_Configuration_List_ListDefaultConfigFactory',
	    		  'tsKey' => 'default'),
	    'pager' =>
	    	array('factory' => 'Tx_PtExtlist_Domain_Configuration_Pager_PagerConfigCollectionFactory',
	    		   'prototype' => 'pager'),
	    'rendererChain' =>
	    	array('factory' => 'Tx_PtExtlist_Domain_Configuration_Renderer_RendererChainConfigFactory',
	    		  'prototype' => 'rendererChain'),
	);
	
	
	/**
	 * Non-merged settings of plugin
	 * @var array
	 */
	protected $origSettings;
	
	
	/**
	 * Prototype settings for ts-configurable objects
	 * @var array
	 */
	protected $protoTypeSettings;
	
	
	/**
	 * Holds list identifier of current list
	 * @var string
	 */
	protected $listIdentifier;
	
	
		
	/**
	 * Constructor is private, use getInstance instead!
	 * 
	 * @param array $settings  Settings of extension
	 */
	public function __construct(array $settings) {	
		$this->setProtoTypeSettings($settings);
		$this->setListIdentifier($settings);
		$this->origSettings = $settings;
		$this->mergeAndSetGlobalAndLocalConf();
	}
	
	
	
	/**
	 * Check and set the prototype settings
	 * @param array $settings
	 */
	protected function setProtoTypeSettings($settings) {
		tx_pttools_assert::isArray($settings['prototype'], array('message' => 'The basic settings are not available. Maybe the static typoscript template for pt_extlist is not included on this page. 1281175089'));
		$this->protoTypeSettings = $settings['prototype'];
	}

	
	
	/**
	 * Sets the list identifier of current list
	 *
	 * @param array $settings
	 */
	protected function setListIdentifier($settings) {
		
		if(!array_key_exists($settings['listIdentifier'], $settings['listConfig'])) {
			if(count($settings['listConfig']) > 0) {
				$helpListIdentifier = 'Available list configurations on this page are: ' . implode(', ', array_keys($settings['listConfig'])) . '.';
			} else {
				$helpListIdentifier = 'No list configurations available on this page.';
			}
			throw new Exception('No list configuration can be found for list identifier "' . $settings['listIdentifier'] . '" 1278419536' . '<br>' . $helpListIdentifier);
		}

        $this->listIdentifier = $settings['listIdentifier'];    
	}	

    
    
    /**
     * Returns identifier of list
     *
     * @return String
     */
    public function getListIdentifier() {
        return $this->listIdentifier;
    }
    
    
    
    /**
     * Returns configuration object for filterbox identifier
     *
     * @param array $filterboxIdentifier
     */
    public function getFilterboxConfigurationByFilterboxIdentifier($filterboxIdentifier) {
    	tx_pttools_assert::isNotEmptyString($filterboxIdentifier, array('message' => 'Filterbox identifier must not be empty! 1277889453'));
    	return $this->buildFilterConfiguration()->getItemById($filterboxIdentifier);
    }
    
    
   /**
	 * Returns a singleton instance of databackend configuration 
	 * @return Tx_PtExtlist_Domain_Configuration_DataBackend_DatabackendConfiguration
	 */
	public function buildDataBackendConfiguration() {
		return $this->buildConfigurationGeneric('dataBackend');
	}
	
	
	
    /**
     * Returns a singleton instance of a fields configuration collection for current list configuration
     *
     * @return Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfigCollection
     */
    public function buildFieldsConfiguration() {
    	return $this->buildConfigurationGeneric('fields');
    }


    
    /**
     * Returns a singleton instance of a aggregateData configuration collection for current list configuration
     * 
     * @return Tx_PtExtlist_Domain_Configuration_Data_Aggregates_AggregateConfigCollection
     */
    public function buildAggregateDataConfig() {
    	return $this->buildConfigurationGeneric('aggregateData');
    }
    
    
    
    /**
     * return a singelton instance of aggregate row collection 
     * 
     * @return Tx_PtExtlist_Domain_Configuration_Aggregates_AggregateRowConfigCollection
     */
    public function buildAggregateRowsConfig() {
    	return $this->buildConfigurationGeneric('aggregateRows');
    }
    
    
    
    /**
     * return a singleton instance of export configuratrion
     * @return Tx_PtExtlist_Domain_Configuration_Export_ExportConfig
     */
    public function buildExportConfiguration() {
    	return $this->buildConfigurationGeneric('export');
    }
    
    
    
    /**
     * Returns a singleton instance of columns configuration collection for current list configuration
     *
     * @return Tx_PtExtlist_Domain_Configuration_Columns_ColumnConfigCollection
     */
    public function buildColumnsConfiguration() {
    	return $this->buildConfigurationGeneric('columns');
    }
    
    
    
	/**
     * Returns a singleton instance of a filter configuration collection for current list configuration
     *
     * @return Tx_PtExtlist_Domain_Configuration_Filters_FilterboxConfigCollection
     */
    public function buildFilterConfiguration() {
    	return $this->buildConfigurationGeneric('filter');
	}
    
	
    
    /**
     * Returns a singleton instance of the renderer chain configuration object.
     * 
     * @return Tx_PtExtlist_Domain_Configuration_Renderer_RendererChainConfig
     */
    public function buildRendererChainConfiguration() {
    	return $this->buildConfigurationGeneric('rendererChain');
    }
    
    
   /**
     * Returns bookmarks configuration
     *
     * @return Tx_PtExtlist_Domain_Configuration_Bookmarks_BookmarksConfig
     */
    public function buildBookmarksConfiguration() {
        return $this->buildConfigurationGeneric('bookmarks');
    }
    
    
    /**
     * @return Tx_PtExtlist_Domain_Configuration_List_ListDefaultConfig
     */
    public function buildListDefaultConfig() {
    	return $this->buildConfigurationGeneric('listDefault');
    }
    
    
    /**
     * Returns configuration object for pager
     *
     * @return Tx_PtExtlist_Domain_Configuration_Pager_PagerConfiguration Configuration object for pager
     */
    public function buildPagerConfiguration() {
    	return $this->buildConfigurationGeneric('pager');
    }

    
    /**
     * Returns a list configuration object
     * 
     * @return Tx_PtExtlist_Domain_Configuration_List_ListConfiguration
     */
    public function buildListConfiguration() {
    	return $this->buildConfigurationGeneric('list');
    }
}

?>