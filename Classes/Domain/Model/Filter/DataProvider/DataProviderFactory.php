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
 * Implements factory for options filter data provider
 * 
 * @author Daniel Lienert <lienert@punkt.de>
 * @package Domain
 * @subpackage Model\Filter\DataProvider
 */
abstract class Tx_PtExtlist_Domain_Model_Filter_DataProvider_DataProviderFactory {
	
	/**
	 * Create a dataprovider for options filter data
	 * 
	 * @param Tx_PtExtlist_Domain_Configuration_Filters_FilterConfig $filterConfig
	 */
	public static function createInstance(Tx_PtExtlist_Domain_Configuration_Filters_FilterConfig $filterConfig) {
		$dataProviderClassName = self::determineDataProviderClass($filterConfig);
		$dataProvider = new $dataProviderClassName();
		
		tx_pttools_assert::isInstanceOf($dataProvider, 'Tx_PtExtlist_Domain_Model_Filter_DataProvider_DataProviderInterface', array('message' => 'The Dataprovider "' . $dataProviderClassName . ' does not implement the required interface! 1283536125'));
		
		$dataProvider->injectFilterConfig($filterConfig);
		$dataProvider->init();
		return $dataProvider;
	}
	
	
	
	/**
	 * Determine the dataProvider to use for filter options
	 * 
	 * TODO: Test me!
	 * @return string dataProviderClass
	 */
	protected static function determineDataProviderClass(Tx_PtExtlist_Domain_Configuration_Filters_FilterConfig $filterConfig) {
		if($filterConfig->getSettings('dataProviderClassName')) {
			$dataProviderClassName = $filterConfig->getSettings('dataProviderClassName');
		} else {
			if($filterConfig->getSettings('options')) {
				$dataProviderClassName = 'Tx_PtExtlist_Domain_Model_Filter_DataProvider_ExplicitData';
			} else {
				$dataProviderClassName = 'Tx_PtExtlist_Domain_Model_Filter_DataProvider_GroupData';
			}
		}
		
		tx_pttools_assert::isTrue(class_exists($dataProviderClassName), array('message' => 'The defined DataProviderClass "'.$dataProviderClassName.'" does not exist! 1283535558'));
		
		return $dataProviderClassName;
	}
	
	
}
?>