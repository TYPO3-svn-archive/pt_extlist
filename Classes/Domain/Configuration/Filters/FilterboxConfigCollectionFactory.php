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
 * Class implementing factory for collection of filterbox configurations
 *
 * @package Domain
 * @subpackage Configuration\Filters
 */
class Tx_PtExtlist_Domain_Configuration_Filters_FilterboxConfigCollectionFactory {
	
	/**
	 * 
	 * @param $configurationBuilder
	 * @return Tx_PtExtlist_Domain_Configuration_Filters_FilterboxConfigCollection
	 */
	public static function getInstance(Tx_PtExtlist_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
		$filterboxCollectionSettings = $configurationBuilder->getSettingsForConfigObject('filter');
		
		$filterBoxConfigCollection = new Tx_PtExtlist_Domain_Configuration_Filters_FilterboxConfigCollection($configurationBuilder);
		foreach($filterboxCollectionSettings as $filterboxIdentifier => $filterboxSettings) {
			$filterboxConfiguration = Tx_PtExtlist_Domain_Configuration_Filters_FilterboxConfigFactory::createInstance($configurationBuilder, $filterboxIdentifier, $filterboxSettings);
			
			$filterBoxConfigCollection->addFilterBoxConfig($filterboxConfiguration, $filterboxIdentifier);
		}
		
		return $filterBoxConfigCollection;
	}
}
?>