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
 * Class implements a string filter
 *
 * @package Domain
 * @subpackage Model\Filter
 * @author Daniel Lienert <lienert@punkt.de>
 * @author Michael Knoll <knoll@punkt.de>
 */
class Tx_PtExtlist_Domain_Model_Filter_StringFilter extends Tx_PtExtlist_Domain_Model_Filter_AbstractSingleValueFilter {
    
    /**
     * Creates filter query from filter value and settings
     * 
     * @return Tx_PtExtlist_Domain_QueryObject_Criteria Criteria for current filter value (null, if empty)
     */
    protected function buildFilterCriteria(Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig $fieldIdentifier) {
    	
    	if ($this->filterValue == '') return NULL; 

    	$fieldName = Tx_PtExtlist_Utility_DbUtils::getSelectPartByFieldConfig($fieldIdentifier);
    	$filterValue = '%'.$this->filterValue.'%';
    	
    	$criteria = Tx_PtExtlist_Domain_QueryObject_Criteria::like($fieldName, $filterValue);	
    	
    	return $criteria;
    }   	
}
?>