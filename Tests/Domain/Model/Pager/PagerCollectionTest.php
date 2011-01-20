<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <lienert@punkt.de>, Michael Knoll <knoll@punkt.de>,
*  Christoph Ehscheidt <ehscheidt@punkt.de>
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

class Tx_PtExtlist_Tests_Domain_Model_Pager_PagerCollectionTest extends Tx_PtExtlist_Tests_BaseTestcase {

	public function setUp() {
		$this->initDefaultConfigurationBuilderMock();
	}

	public function testAddPager() {
		$collection = new Tx_PtExtlist_Domain_Model_Pager_PagerCollection($this->configurationBuilderMock);
		
		$pager = $this->getMock('Tx_PtExtlist_Domain_Model_Pager_DefaultPager', array('setCurrentPage'), array(),'',false, false, true);

		$collection->addPager($pager);
	}
	
	/** @test */
	public function setPageByItemIndex() {
		$collection = new Tx_PtExtlist_Domain_Model_Pager_PagerCollection($this->configurationBuilderMock);
		$pager = $this->getMock('Tx_PtExtlist_Domain_Model_Pager_DefaultPager', array('setCurrentPage'), array(),'',false, false, true);
		$collection->addPager($pager);
		
		$collection->setItemsPerPage(5);
		
		$collection->setPageByItemIndex(1);
		$this->assertEquals(0,$collection->getCurrentPage());
		
		$collection->setPageByItemIndex(4);
		$this->assertEquals(0,$collection->getCurrentPage());
		
		$collection->setPageByItemIndex(5);
		$this->assertEquals(1,$collection->getCurrentPage());
	}	
}
?>