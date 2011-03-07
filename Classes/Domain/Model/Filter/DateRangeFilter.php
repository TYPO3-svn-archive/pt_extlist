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
 * Filter for date range
 * 
 * @author Michael Knoll
 * @package Domain
 * @subpackage Model\Filter
 */
class Tx_PtExtlist_Domain_Model_Filter_DateRangeFilter extends Tx_PtExtlist_Domain_Model_Filter_AbstractSingleValueFilter {
	
	/**
	 * Holds timestamp of start-time for filter
	 *
	 * @var int
	 */
	protected $filterValueFrom;
	
	
	
	/**
	 * Holds time stamp of end-time for filter
	 *
	 * @var int
	 */
	protected $filterValueTo;
	
	
	
	/**
	 * Getter fro FROM filter value
	 * 
	 * @return string
	 */
	public function getFilterValueFrom() {
		return $this->filterValueFrom;
	}
	
	
	
	/**
	 * Getter for TO filter value
	 *
	 * @return string
	 */
	public function getFilterValueTo() {
		return $this->filterValueTo;
	}
	
	

    /**
     * Creates filter query from filter value and settings
     *
     * @param Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig $fieldIdentifierFrom
     * @param Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig $fieldIdentifierTo
     * @return Tx_PtExtlist_Domain_QueryObject_Criteria Criteria for current filter value (null, if empty)
     */
    protected function buildFilterCriteria(Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig $fieldIdentifier) {

        if ($this->filterValueFrom == '' || $this->filterValueTo == '') {
            return NULL;
        }

        $fieldName = Tx_PtExtlist_Utility_DbUtils::getSelectPartByFieldConfig($fieldIdentifier);

        $criteria1 = Tx_PtExtlist_Domain_QueryObject_Criteria::greaterThanEquals($fieldName, $this->filterValueFrom);
        $criteria2 = Tx_PtExtlist_Domain_QueryObject_Criteria::lessThanEquals($fieldName, $this->filterValueTo);
        $criteria = Tx_PtExtlist_Domain_QueryObject_Criteria::andOp($criteria1, $criteria2);
        return $criteria;
    }
    
    

    /**
     * Template method for initializing filter by get / post vars
     */
    protected function initFilterByGpVars() {
        if(array_key_exists('filterValueFrom', $this->gpVarFilterData)) {
            $this->filterValueFrom = $this->gpVarFilterData['filterValueFrom']; 
        }
        if(array_key_exists('filterValueTo', $this->gpVarFilterData)) {
            $this->filterValueTo = $this->gpVarFilterData['filterValueTo']; 
        }
    }
    
    

    /**
     * Template method for initializing filter by session data
     */
    protected function initFilterBySession() {
        $this->filterValueFrom = array_key_exists('filterValueFrom', $this->sessionFilterData) ? $this->sessionFilterData['filterValueFrom'] : $this->filterValueFrom;
        $this->filterValueTo = array_key_exists('filterValueTo', $this->sessionFilterData) ? $this->sessionFilterData['filterValueTo'] : $this->filterValueTo;
    }
    
    
    
    /**
     * Template method for initializing filter by TS configuration
     */
    protected function initFilterByTsConfig() {
    	// TODO We don't use this here (so far)
        // $this->filterValueFrom = $this->filterConfig->getDefaultValue() ? $this->filterConfig->getDefaultValue() : $this->filterValue;
    }
   
    
    
    /**
     * (non-PHPdoc)
     * @see Classes/Domain/Model/Filter/Tx_PtExtlist_Domain_Model_Filter_AbstractFilter::setActiveState()
     */
    protected function setActiveState() {
    	// TODO we don't use this here (so far)
        // $this->isActive = $this->filterValue != $this->filterConfig->getInactiveValue() ? true : false;
        $this->isActive = true; 
    }
    
    
    
    /**
     * (non-PHPdoc)
     * @see Classes/Domain/Model/Filter/Tx_PtExtlist_Domain_Model_Filter_AbstractFilter::initFilter()
     */
    protected function initFilter() {
        
    }
    
    
    
    /**
     * Adds some fields for rendering breadcrumbs.
     *
     * @return array
     */
    protected function getFieldsForBreadcrumb() {
        $parentArray = parent::getFieldsForBreadCrumb();
        $parentArray['fromValue'] = $this->filterValueFrom;
        $parentArray['toValue'] = $this->filterValueTo;
        return $parentArray;
    }
    
    
    
    /**
     * Persists filter state to session
     *
     * @return array Array of filter data to persist to session
     */
    public function persistToSession() {
        return array(
            'filterValueFrom' => $this->filterValueFrom, 
            'invert' => $this->invert,
            'filterValueTo' => $this->filterValueTo
        );
    }
    
}
 
?>