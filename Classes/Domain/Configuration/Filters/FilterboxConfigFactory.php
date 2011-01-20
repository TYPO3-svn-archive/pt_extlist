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
 * Factory for filterbox configuration
 * 
 * @author Michael Knoll <knoll@punkt.de>
 * @author Daniel Lienert <lienert@punkt.de>
 * @package Domain
 * @subpackage Configuration\Filters
 */
class Tx_PtExtlist_Domain_Configuration_Filters_FilterboxConfigFactory {

	public static function createInstance(Tx_PtExtlist_Domain_Configuration_ConfigurationBuilder $configurationBuilder, $filterboxIdentifier, array $filterBoxSettings) {
		$filterboxConfiguration = new Tx_PtExtlist_Domain_Configuration_Filters_FilterboxConfig($configurationBuilder, $filterboxIdentifier, $filterBoxSettings);
		
		foreach($filterBoxSettings['filterConfigs'] as $arrayIndex => $filterSettings) {
			tx_pttools_assert::isArray($filterSettings, array('message' => 'No array given for filter settings. Perhaps misconfiguration of TS for filterbox? 1280772788'));
			$filterConfig = Tx_PtExtlist_Domain_Configuration_Filters_FilterConfigFactory::createInstance($configurationBuilder, $filterboxIdentifier, $filterSettings);
			$filterboxConfiguration->addFilterConfig($filterConfig, $arrayIndex);
		}
		
		return $filterboxConfiguration;
	}
}
?>