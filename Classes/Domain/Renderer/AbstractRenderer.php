<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert , Michael Knoll ,
*  Christoph Ehscheidt <ehscheidt@punkt.de
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
 * Abstract class for list renderers
 * 
 * @package Domain
 * @subpackage Renderer
 * @author Christoph Ehscheidt 
 * @author Michael Knoll 
 * @author Daniel Lienert 
 */
abstract class Tx_PtExtlist_Domain_Renderer_AbstractRenderer implements Tx_PtExtlist_Domain_Renderer_ConfigurableRendererInterface {

	/**
	 * @var Tx_PtExtlist_Domain_Configuration_Renderer_RendererConfig
	 */
	protected $rendererConfiguration;
	
	
	
	/**
	 * Inject the Configuration Builder
	 * 
	 * @param Tx_PtExtlist_Domain_Configuration_Renderer_RendererConfig $rendererConfiguration
	 */
	public function injectConfiguration(Tx_PtExtlist_Domain_Configuration_Renderer_RendererConfig $rendererConfiguration) {
		$this->rendererConfiguration = $rendererConfiguration;
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Domain/Renderer/Tx_PtExtlist_Domain_Renderer_RendererInterface::renderList()
	 */
	public function renderList(Tx_PtExtlist_Domain_Model_List_ListData $listData) {
		return $listData;
	}
	
	
	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Domain/Renderer/Tx_PtExtlist_Domain_Renderer_RendererInterface::renderCaptions()
	 */
	public function renderCaptions(Tx_PtExtlist_Domain_Model_List_Header_ListHeader $listHeader) {
		return $listHeader;
	}
	
	
	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Domain/Renderer/Tx_PtExtlist_Domain_Renderer_RendererInterface::renderAggregateList()
	 */
	public function renderAggregateList(Tx_PtExtlist_Domain_Model_List_ListData $aggregateListData) {
		return $aggregateListData;
	}
	
	
}

?>