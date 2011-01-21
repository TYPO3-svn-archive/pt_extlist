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
 * Class implements pager configuration collection
 *
 * @package Domain
 * @subpackage Configuration\Pager
 * @author Daniel Lienert 
 */
class Tx_PtExtlist_Domain_Configuration_Pager_PagerConfigCollection extends tx_pttools_objectCollection {
	
	protected $listIdentifier;
	protected $restrictedClassName = 'Tx_PtExtlist_Domain_Configuration_Pager_PagerConfig';
	
	
	
	/**
	 * @param Tx_PtExtlist_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 */
	public function __construct(Tx_PtExtlist_Domain_Configuration_ConfigurationBuilder $configurationBuilder) {
		$this->listIdentifier = $configurationBuilder->getListIdentifier();
	}
	
	
	
	/**
	 * Add pagerconig to list
	 * 
	 * @param Tx_PtExtlist_Domain_Configuration_Pager_PagerConfig $pagerConfig
	 * @param string $pagerIdentifier
	 */
	public function addPagerConfig(Tx_PtExtlist_Domain_Configuration_Pager_PagerConfig $pagerConfig, $pagerIdentifier) {
		$this->addItem($pagerConfig, $pagerIdentifier);
	}
	
}
?>