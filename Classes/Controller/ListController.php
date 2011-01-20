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
 * Controller for all list actions
 * 
 * @package Controller
 * @author Michael Knoll <knoll@punkt.de>
 * @author Daniel Lienert <lienert@punkt.de>
 */
class Tx_PtExtlist_Controller_ListController extends Tx_PtExtlist_Controller_AbstractController {
	
	/**
	 * Holds an instance of list renderer
	 *
	 * @var Tx_PtExtlist_Domain_Renderer_RendererChain
	 */
	protected $rendererChain;
	
	
	
	/**
	 * Initializes controller
	 */
	public function initializeAction() {
		parent::initializeAction();
		$this->rendererChain = Tx_PtExtlist_Domain_Renderer_RendererChainFactory::getRendererChain($this->configurationBuilder->buildRendererChainConfiguration());
	}
	
	
	
	/**
	 * List action rendering list
	 *
	 * @return string  Rendered list for given list identifier
	 */
	public function listAction() {
		$list = Tx_PtExtlist_Domain_Model_List_ListFactory::createList($this->dataBackend, $this->configurationBuilder);

		
		// Do not show the list if it is empty.
		// TODO do not use forward here!!!
		if($list->getListData()->count() <= 0) $this->forward('emptyList');
	
		
		$renderedListData = $this->rendererChain->renderList($list->getListData());
		$renderedCaptions = $this->rendererChain->renderCaptions($list->getListHeader());
		$renderedAggregateRows = $this->rendererChain->renderAggregateList($list->getAggregateListData());
		$this->view->assign('config', $this->configurationBuilder);
		$this->view->assign('listHeader', $list->getListHeader());
		$this->view->assign('listCaptions', $renderedCaptions);
		$this->view->assign('listData', $renderedListData);
		$this->view->assign('aggregateRows', $renderedAggregateRows);
	}
	
	
	
	/**
	 * Export action for exporting list data
	 *
	 * @return mixed Whatever format-specific view returns
	 */
	public function exportAction() {
		$list = Tx_PtExtlist_Domain_Model_List_ListFactory::createList($this->dataBackend, $this->configurationBuilder);

        $renderedListData = $this->rendererChain->renderList($list->getListData());
        $renderedCaptions = $this->rendererChain->renderCaptions($list->getListHeader());
        $renderedAggregateRows = $this->rendererChain->renderAggregateList($list->getAggregateListData());
        
        $this->view->assign('config', $this->configurationBuilder);
        
        $this->view->assign('listHeader', $list->getListHeader());
        $this->view->assign('listCaptions', $renderedCaptions);
        $this->view->assign('listData', $renderedListData);
        $this->view->assign('aggregateRows', $renderedAggregateRows);
		return $this->view->render();
	}
	
	
	
	/**
	 * Shows a message that the list is empty.
	 * 
	 * @return string A message saying that the list is empty.
	 */
	public function emptyListAction() {
		// template handles translation...
	}
	
	
	
	/**
	 * Sorting action used to change sorting of a list
	 *
	 * @return string Rendered sorting action
	 */
	public function sortAction() {
		$headerList = $this->dataBackend->getListHeader();
		$headerList->reset(); 
		$this->forward('list');
	}	
}
?>