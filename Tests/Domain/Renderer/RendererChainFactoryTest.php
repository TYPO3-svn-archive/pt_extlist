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
 * Testcase for renderer chain factory
 *
 * @package pt_extlist
 * @subpackage Tests\Domain\Renderer
 * @author Michael Knoll 
 */
class Tx_PtExtlist_Tests_Domain_Renderer_RendererChainFactoryTest extends Tx_PtExtlist_Tests_BaseTestcase {
    
	/**
	 * Sets up testcase
	 */
	public function setUp() {
		$this->initDefaultConfigurationBuilderMock();
	}
	
	
	
	/** @test */
	public function testSetup() {
		$this->isTrue(class_exists('Tx_PtExtlist_Domain_Renderer_RendererChainFactory'));
	}
	
	
	
	/** @test */
	public function getRendererChainReturnsRendererChainForConfiguration() {
		$rendererChainConfiguration = $this->configurationBuilderMock->buildRendererChainConfiguration();
		$rendererChain = Tx_PtExtlist_Domain_Renderer_RendererChainFactory::getRendererChain($rendererChainConfiguration);
		$renderers = $rendererChain->getRenderers();
		$this->assertEquals(get_class($renderers[0]), 'Tx_PtExtlist_Tests_Domain_Renderer_DummyRenderer');
	}
	
}
?>