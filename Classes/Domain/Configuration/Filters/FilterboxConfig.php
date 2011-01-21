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
 * Class Filterbox Config 
 * 
 * @author Daniel Lienert 
 * @package Domain
 * @subpackage Configuration\Filters
 */
class Tx_PtExtlist_Domain_Configuration_Filters_FilterboxConfig extends tx_pttools_objectCollection {

	
	/**
	 * Hash map between filter identifier and numeric filter index
	 * 
	 * @var array
	 */
	protected $filterIdentifierToFilterIndex;
	
	
	/**
	 * Identifier of current list
	 * @var string
	 */
	protected $listIdentifier;
	
	
	/**
	 * @var string
	 */
	protected $restrictedClassName = 'Tx_PtExtlist_Domain_Configuration_Filters_FilterConfig';
	
	
	/**
	 * Identifier of this filterbox
	 * @var string
	 */
	protected $filterboxIdentifier;

	
	/**
	 * Show a reset link / button
	 * @var boolean
	 */
	protected $showReset = true;

	
	/**
	 * Show a submit link / button
	 * @var boolean
	 */
	protected $showSubmit = true;
	
	
	/**
	 * @param Tx_PtExtlist_Domain_Configuration_ConfigurationBuilder $configurationBuilder
	 * @param string $filterboxIdentifier
	 * @param array $filterBoxSettings
	 */
	public function __construct(Tx_PtExtlist_Domain_Configuration_ConfigurationBuilder $configurationBuilder, $filterboxIdentifier, $filterBoxSettings) {
		
		tx_pttools_assert::isNotEmptyString($filterboxIdentifier, array('message' => 'FilterboxIdentifier must not be empty! 1277889451'));
		
		$this->listIdentifier = $configurationBuilder->getListIdentifier();
		$this->filterboxIdentifier = $filterboxIdentifier;
		
		$this->setOptionalSettings($filterBoxSettings);
	}
	
	
	/**
	 * Add FilterConfig to the FilterboxConfig
	 * 
	 * @param Tx_PtExtlist_Domain_Configuration_Filters_FilterConfig $filterConfig
	 * @param string $filterIdentifier
	 */
	public function addFilterConfig(Tx_PtExtlist_Domain_Configuration_Filters_FilterConfig $filterConfig, $filterIndex)  {
		$this->addItem($filterConfig, $filterIndex);
		$this->filterIdentifierToFilterIndex[$filterConfig->getFilterIdentifier()] = $filterIndex;
	}
	
	
	
	/**
	 * Get the filterconfig by filterIdentifier
	 * 
	 * @param sting $filterIdentifier
	 * @return Tx_PtExtlist_Domain_Configuration_Filters_FilterConfig
	 */
	public function getFilterConfigByFilterIdentifier($filterIdentifier) {
		return $this->getItemById($this->filterIdentifierToFilterIndex[$filterIdentifier]);
	}
	
	
	
	/**
	 * Set the optional settings
	 * 
	 * @param array $filterBoxSettings
	 */
	protected function setOptionalSettings($filterBoxSettings) {
		
		if(array_key_exists('showReset', $filterBoxSettings)) {
			$this->showReset = $filterBoxSettings['showReset'] == 1 ? true : false;
		}
		
		if(array_key_exists('showSubmit', $filterBoxSettings)) {
			$this->showSubmit = $filterBoxSettings['showSubmit'] == 1 ? true : false;
		}
		
	} 
	
	
	
	/**
	 * @return string filterboxIdentifier
	 */
	public function getFilterboxIdentifier() {
		return $this->filterboxIdentifier;
	}
	
	
	
	/**
	 * @return string listIdentifier
	 */
	public function getListIdentifier() {
		return $this->listIdentifier;
	}
	
	
	
	/**
	 * Show Reset button / link in filterbox
	 * @return boolean showReset
	 */
	public function getShowReset() {
		return $this->showReset;
	}
	
	
	/**
	 * Show Submit button / link in filterbox
	 * @return boolean showSubmit
	 */
	public function getShowSubmit() {
		return $this->showSubmit;
	}	
}
?>