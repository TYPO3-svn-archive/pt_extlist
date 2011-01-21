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
 * Class Pager Controller
 *
 * @author Christoph Ehscheidt 
 * @package Controller
 */
class Tx_PtExtlist_Controller_PagerController extends Tx_PtExtlist_Controller_AbstractController {

	/**
	 * Holds the pager collection.
	 * 
	 * @var Tx_PtExtlist_Domain_Model_Pager_PagerCollection
	 */
	protected $pagerCollection;
	
	
	
	/**
	 * The pager identifier of the pager configured for this view.
	 * 
	 * @var string
	 */
	protected $pagerIdentifier;

	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Controller/Tx_PtExtlist_Controller_AbstractController::initializeAction()
	 */
	public function initializeAction() {
		$this->pagerCollection = $this->getPagerCollectionInstance();
		$this->pagerIdentifier = (empty($this->settings['pagerIdentifier']) ? 'default' : $this->settings['pagerIdentifier']);
	}
	
	
	
	/**
	 * Shows a pager as a frontend plugin
	 *
	 * @return string Rendered pager action HTML source
	 */
	public function showAction() {
		// Do not show pager when nothing to page.
		if($this->pagerCollection->getItemCount() <= 0) return '';

		$pager = $this->pagerCollection->getPagerByIdentifier($this->pagerIdentifier);
		
		// TODO change testcase to accept this call
		// TODO think about using initializeView method call for all this
		#$this->setTemplatePathAndFilename('EXT:pt_extlist/Resources/Private/Templates/Pager/second.html');
		$templatePath = $pager->getPagerConfiguration()->getTemplatePath();
		if(!empty($templatePath)) {
			$this->setTemplatePathAndFilename($templatePath);			
		}
		
		$this->view->assign('pagerCollection', $this->pagerCollection);
		$this->view->assign('pager', $pager);
	}

	
	
	/**
	 * Returns an initialized pager object
	 * 
	 * @return Tx_PtExtlist_Domain_Model_Pager_PagerInterface
	 */
	protected function getPagerCollectionInstance() {
		$pagerCollection = Tx_PtExtlist_Domain_Model_Pager_PagerCollectionFactory::getInstance($this->configurationBuilder);
		$pagerCollection->setItemCount($this->dataBackend->getTotalItemsCount());
		
        return $pagerCollection;
	}
}
?>