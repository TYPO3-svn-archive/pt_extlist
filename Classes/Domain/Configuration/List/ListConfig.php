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
 * Class implements configuration for list defaults
 *
 * @package Domain
 * @subpackage Configuration\List
 * @author Daniel Lienert 
 */
class Tx_PtExtlist_Domain_Configuration_List_ListConfig extends Tx_PtExtlist_Domain_Configuration_AbstractExtlistConfiguration {
	
	/**
	 * @var string 
	 */
	protected $headerPartial;
	
	
	/**
	 * @var string
	 */
	protected $bodyPartial;
	
	
	/**
	 * @var string headerPartial
	 */
	protected $aggregateRowsPartial;

	
	/**
	 * @var boolean
	 */
	protected $useSession = true;
	
	
	/**
	 * Set the properties
	 */
	protected function init() {
		$this->setValueIfExistsAndNotNothing('headerPartial');
		$this->setValueIfExistsAndNotNothing('bodyPartial');
		$this->setValueIfExistsAndNotNothing('aggregateRowsPartial');
		
		$this->setBooleanIfExistsAndNotNothing('useSession');

		/**
		 * Force useSession to fale if the extension is in cache mode
		 */
		if(Tx_PtExtlist_Utility_Extension::isInCachedMode()) {
			$this->useSession = false;
		}
	}


	/**
	 * @return string
	 */
	public function getHeaderPartial() {
		return $this->headerPartial;
	}
	
	
	
	/**
	 * @return string
	 */
	public function getBodyPartial() {
		return $this->bodyPartial;		
	}
	
	
	
	/**
	 * @return string
	 */
	public function getAggregateRowsPartial() {
		return $this->aggregateRowsPartial;
	}
	
	
	
	/**
	 * @return boolean use Session
	 */
	public function getUseSession() {
		return $this->useSession;
	}
}
?>