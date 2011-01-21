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
 * Abstract filter class for filter models
 * 
 * @author Michael Knoll 
 * @author Daniel Lienert 
 * @package Domain
 * @subpackage Model\Filter
 */
abstract class Tx_PtExtlist_Domain_Model_Filter_AbstractFilter 
    implements Tx_PtExtlist_Domain_Model_Filter_FilterInterface, 
               Tx_PtExtlist_Domain_StateAdapter_SessionPersistableInterface,
               Tx_PtExtlist_Domain_StateAdapter_GetPostVarInjectableInterface {
    	
    /**
     * Identifier of list to which this filter belongs to
     *
     * @var String
     */	
    protected $listIdentifier;

    
    
    /**
     * Filter Box Identifier
     * 
     * @var String
     */
    protected $filterBoxIdentifier;
    	
    
    
	/**
	 * Identifier of this filter
	 *
	 * @var String
	 */
	protected $filterIdentifier;
	
	
	
	/**
	 * Holds a filter configuration for this filter
	 *
	 * @var Tx_PtExtlist_Domain_Configuration_Filters_FilterConfig
	 */
	protected $filterConfig;
	
	
	
	/**
	 * Holds data from session stored by this filter
	 *
	 * @var array
	 */
	protected $sessionFilterData;
	
	
	
	/**
	 * Holds data from GP vars submitted for this filter
	 *
	 * @var array
	 */
	protected $gpVarFilterData;
	
	
	
	/**
	 * Get/Post vars adapter
	 *
	 * @var Tx_PtExtlist_Domain_StateAdapter_GetPostVarAdapter
	 */
	protected $gpVarAdapter = null;
	
	
	
	/**
	 * Indicates if this filter is inverted
	 *
	 * @var boolean
	 */
	protected $invert = false;
	
	
	
	/**
	 * Session persistence manager
	 *
	 * @var Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManager
	 */
	protected $sessionPersistenceManager = null;
	
	
	
	/**
	 * Holds query object for this filter
	 * 
	 * @var Tx_PtExtlist_Domain_QueryObject_Query
	 */
	protected $filterQuery = null;
	
	
	 
	/**
     * Identifier of field on which this filter is operating (database field to be filtered)
     *
     * @var Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfigCollection
     */
    protected $fieldIdentifierCollection;
	
	
	
	/**
	 * Holds a reference to associated data backend
	 *
	 * @var Tx_PtExtlist_Domain_DataBackend_DataBackendInterface
	 */
	protected $dataBackend = null;
	
	
	
	/**
	 * Indicates if the filter is active
	 * 
	 * @var boolean
	 */
	protected $isActive = false;
	
	
		
	/**
	 * Holds an error message for this filter
	 *
	 * @var string
	 */
	protected $errorMessage = '';
	
	
	
	/**
	 * Constructor for filter
	 *
	 * @param String $filterIdentifier     Identifier for filter
	 */
	public function __construct() {
		$this->filterQuery = new Tx_PtExtlist_Domain_QueryObject_Query();
		$this->errorMessages = new Tx_PtExtlist_Domain_Model_Messaging_MessageCollection();
	}
	
	
	
	/**
	 * Injects filter configuration for this filter
	 *
	 * @param Tx_PtExtlist_Domain_Configuration_Filters_FilterConfig $filterConfig
	 */
	public function injectFilterConfig(Tx_PtExtlist_Domain_Configuration_Filters_FilterConfig $filterConfig) {
		$this->filterConfig = $filterConfig;
		
        $this->listIdentifier = $filterConfig->getListIdentifier();
        $this->filterBoxIdentifier = $filterConfig->getFilterboxIdentifier();
        $this->filterIdentifier = $filterConfig->getFilterIdentifier();
	}


	
	/**
	 * Injector for Get/Post Vars adapter
	 *
	 * @param Tx_PtExtlist_Domain_StateAdapter_GetPostVarAdapter $gpVarAdapter Get/Post vars adapter to be injected
	 */
	public function injectGpVarAdapter(Tx_PtExtlist_Domain_StateAdapter_GetPostVarAdapter $gpVarAdapter) {
		$this->gpVarAdapter = $gpVarAdapter;
	}
	
	
	
	/**
	 * Injector for session persistence manager
	 *
	 * @param Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManager $sessionPersistenceManager
	 */
	public function injectSessionPersistenceManager(Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManager $sessionPersistenceManager) {
		$this->sessionPersistenceManager = $sessionPersistenceManager;
	}
	
	
	
	/**
	 * Injector for associated data backend
	 *
	 * @param Tx_PtExtlist_Domain_DataBackend_DataBackendInterface $dataBackend
	 */
	public function injectDataBackend(Tx_PtExtlist_Domain_DataBackend_DataBackendInterface $dataBackend) {
		$this->dataBackend = $dataBackend;
	}
	
	
	
	/**
	 * Returns filter identifier
	 *
	 * @return string Identifier of filter
	 */
	public function getFilterIdentifier() {
		return $this->filterIdentifier;
	}
	
	
	
	/**
	 * Returns list identifier
	 * 
	 * @return string Identifier of list to which this filter belongs to
	 */
	public function getListIdentifier() {
		return $this->listIdentifier;
	}
	
	
	
	/** 
	 * Returns filterbox identifier for this filter
	 * 
	 * @return String
	 */
	public function getFilterBoxIdentifier() {
		return $this->filterBoxIdentifier;
	}
	
	
	
	/**
	 * Returns TS config of this filter
	 *
	 * @return array TS config of this filter
	 */
	public function getTsConfig() {
		return $this->filterConfig->getSettings();
	}
	
	
	
	/**
	 * Returns filter configuration of this filter
	 *
	 * @return Tx_PtExtlist_Domain_Configuration_Filters_FilterConfiguration
	 */
	public function getFilterConfig() {
		return $this->filterConfig;
	}
	
	
	
	/**
	 * Returns label of filter as configured in TS
	 *
	 * @return string Label of filter as configured in TS
	 */
	public function getLabel() {
		return $this->filterConfig->getLabel();
	}
	
	
	
	/**
	 * Returns query set up by filter. Query contains
	 * all criterias set by filter
	 *
	 * @return Tx_PtExtlist_Domain_QueryObject_Query
	 */
	public function getFilterQuery() {
		return $this->filterQuery;
	}
	
	
	
	/**
	 * Return if this filter is inverted
	 * 
	 * @return boolean
	 */
    public function getInvert() {
		return $this->invert;
	}
	
	
	
	/**
	 * Returns true, if filter is active
	 *
	 * @return bool True, if filter is active
	 */
	public function isActive() {
		return $this->isActive;
	}
	
	
	
	/**
	 * Returns collection of error messages if filter does not validate
	 *
	 * @return string
	 */
    public function getErrorMessage() {
    	return $this->errorMessage;
    }
    
    
	
	/**
	 * Initializes the filter
	 * 
	 * @return void
	 */
	public function init() {
		
		/**
		 * What happens during initialization:
		 * 
		 * 1. When being constructed, filter gets injected:
		 * 1.1. Filter configuration from TS
		 * 1.2. Session data from session adapter
		 * 1.3. Get / Post vars from gpVarAdapter
		 * 
		 * 2. After construction, init() is called
		 * 2.1. Init calls method to init filter by TS configuration
		 * 2.2. Init calls method to init filter by session data
		 * 2.3. Init calls method to init filter by get / post vars 
		 * 2.4. Sets the filter active
		 * 
		 * 3. Store filter data to session
		 * 
		 * 4. Create filter query
		 * 
		 * I you want to change the way, a filter initializes itsel, you have
		 * to override init() in your own filter implementation!
		 */

		$this->initGenericFilterByTSConfig();
		$this->initFilterByTsConfig();
		
		$this->initGenericFilterBySession();
		$this->initFilterBySession();
		
		$this->initGenericFilterByGPVars();
		$this->initFilterByGpVars();
		
		$this->setActiveState();
		$this->initFilter();
		
		$this->buildFilterQuery();
		
	}
	
	
	
    /**
	 * Set generic config variables that exist for all filters
	 * 
	 */
	protected function initGenericFilterByTSConfig() {
		$this->fieldIdentifierCollection = $this->filterConfig->getFieldIdentifier();
		$this->invert = $this->filterConfig->getInvert();
	}
	
	
	
	/**
	 * Set generic filter values from GPVars
	 * 
	 */
	protected function initGenericFilterByGPVars() {
		if($this->filterConfig->getInvertable()) {
			if(isset($this->gpVarFilterData['invert'])) {
				$this->invert = $this->gpVarFilterData['invert'] ? true : false;	
			}
		}
	}
	
	
	
	/**
	 * Set generic filter values from Session
	 * 
	 */
	protected function initGenericFilterBySession() {
		if($this->filterConfig->getInvertable()) {
			$this->invert = $this->sessionFilterData['invert'] ? true : false;
		}		
	}
	
	
	
	/**
	 * Template method for initializing filter by TS configuration
	 */
	abstract protected function initFilterByTsConfig();
	
	

	/**
	 * Template method for initializing filter by session data
	 */
	abstract protected function initFilterBySession();
	
	

	/**
	 * Template method for initializing filter by get / post vars
	 */
	abstract protected function initFilterByGpVars();
	
	
	
	/**
	 * Template method for initializing filter after setting all data
	 */
	abstract protected function initFilter();
	
	
	
	/**
	 * Build filter query for current filter state 
	 * 
	 */
	protected function buildFilterQuery() {
		if($this->isActive) $criteria = $this->buildFilterCriteriaForAllFields();
			
		if($criteria) {
			if($this->invert) {
				$this->filterQuery->addCriteria(Tx_PtExtlist_Domain_QueryObject_Criteria::notOp($criteria));
			} else {
				$this->filterQuery->addCriteria($criteria);
			}
		}
	}
	
	
	
	/**
	 * Sets the active state of this filter
	 */
	abstract protected function setActiveState();
	
	

	/**
	 * Build the filterCriteria for a single field
	 * 
	 * @api
	 * @param Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig $fieldIdentifier
	 */
	abstract protected function buildFilterCriteria(Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig $fieldIdentifier);
	
	
	/**
	 * Build the filterCriteria for filter 
	 * 
	 * @return Tx_PtExtlist_Domain_QueryObject_Criteria
	 */
	protected function buildFilterCriteriaForAllFields() {
		$criteria = NULL;
		
		foreach($this->fieldIdentifierCollection as $fieldIdentifier) {	
			$singleCriteria = $this->buildFilterCriteria($fieldIdentifier);
			
			if($criteria) {
				$criteria = Tx_PtExtlist_Domain_QueryObject_Criteria::orOp($criteria, $singleCriteria);
			} else {
				$criteria = $singleCriteria;
			}
		}
		
		return $criteria;
	}
	

	/**
	 * Template method for validating filter data.
	 * 
	 * Method should write error messages to $this->errorMessages array
	 *
	 * @return bool True, if filter validates, false, if filter does not validate
	 */
	public function validate() {
		return 1;
	}
	
	
	
	/**
	 * Wrapper method for validate(). Needed for Fluid access.
	 * 
	 * @return bool
	 */
    public function getValidate() {
    	return $this->validate();
    }
    
    
    
    /**
     * Returns filter breadcrumb for this filter.
     * Most likely to be overwritten in concrete filter class.
     *
     * @return Tx_PtExtlist_Domain_Model_BreadCrumbs_BreadCrumb
     */
    public function getFilterBreadCrumb() {
        
    	$breadCrumb = new Tx_PtExtlist_Domain_Model_BreadCrumbs_BreadCrumb($this);
        
        if ($this->getFilterValueForBreadCrumb() != '') {
            $breadCrumbRenderArray = $this->filterConfig->getBreadCrumbString();
            
            $breadCrumbMessage = Tx_PtExtlist_Utility_RenderValue::renderDataByConfigArray(
                $this->getFieldsForBreadcrumb(), 
                $breadCrumbRenderArray);
            
            $breadCrumb->setMessage($breadCrumbMessage);
            $breadCrumb->setIsResettable(true);
        }
        
        return $breadCrumb;
    }
    
    
    
    /**
     * Returns an array of fields to be used for rendering breadcrumb message.
     * 
     * Per default, this is the label of the filter and its value. Feel free to add
     * further values in your own filter classes 
     *
     * @return array
     */
    protected function getFieldsForBreadcrumb() {
    	return array(
    	   'label' => $this->filterConfig->getLabel(), 
    	   'value' => $this->getFilterValueForBreadCrumb()
    	);
    }
    
    
    
    /**
     * Returns a string to be shown as filter value in breadcrumb
     * 
     * @return string
     */
    abstract protected function getFilterValueForBreadCrumb();
    
    
    
    /**
     * Returns a field configuration for a given identifier
     *
     * @param string $fieldIdentifier
     * @return Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig Field configuration for given identifier
     */
    protected function resolveFieldConfig($fieldIdentifier) {   
        return $this->dataBackend->getFieldConfigurationCollection()->getFieldConfigByIdentifier($fieldIdentifier);
    }
	
    
    
	/****************************************************************************************************************
     * Methods implementing "Tx_PtExtlist_Domain_StateAdapter_GetPostVarInjectableInterface"
     *****************************************************************************************************************/
	
	/**
	 * Injector for GET & POST vars
	 *
	 * @param array $gpVars
	 */
	public function injectGPVars($gpVars) {
		$this->gpVarFilterData = $gpVars;
	}
	
	
	
	/****************************************************************************************************************
	 * Methods implementing "Tx_PtExtlist_Domain_SessionPersistence_SessionPersistableInterface"
	 *****************************************************************************************************************/

	/**
	 * Returns namespace for this object
	 * 
	 * @return string Namespace to identify this object
	 */
	public function getObjectNamespace() {
		return  $this->listIdentifier . '.filters.' . $this->filterBoxIdentifier . '.' . $this->filterIdentifier;
	}
	
	
	
	/**
	 * Injects data from session persistence for this filter
	 *
	 * @param array $sessionData Session data, that was previously stored to session by this filter
	 */
	public function injectSessionData(array $sessionData) {
		$this->sessionFilterData = $sessionData;
	}
	
}
?>
