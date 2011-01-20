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

/**
 * Default renderer for a cell in a row in list data
 * 
 * @package Domain
 * @subpackage Renderer\Default
 * @author Christoph Ehscheidt <ehscheidt@punkt.de>
 * @author Daniel Lienert <lienert@punkt.de>
 */
class Tx_PtExtlist_Domain_Renderer_Default_CellRenderer {

	/**
	 * Reference to the ConfigurationBuilder
	 * @var Tx_PtExtlist_Domain_Configuration_ConfigurationBuilder
	 */
	protected $configurationBuilder;
	
	
	
	/**
	 *
	 * @var Tx_PtExtlist_Domain_Configuration_Renderer_RendererConfiguration
	 */
	protected $rendererConfiguration;
	
	
	
	/**
	 * Special renderer userfunciton
	 * 
	 * @var string
	 */
	protected $renderSpecialCellUserFunc;
	
	
	
	/**
	 * Construct the strategy.
	 *
	 * @param Tx_PtExtlist_Domain_Configuration_Renderer_RendererConfiguration $configuration
	 */
	public function __construct(Tx_PtExtlist_Domain_Configuration_Renderer_RendererConfig $rendererConfiguration) {
		$this->rendererConfiguration = $rendererConfiguration;
		#$this->renderSpecialCellUserFunc = $this->rendererConfiguration->getSpecialCell();
	}
	
	
	
	/**
	 * Renders the cell content.
	 *
	 * @param string $columnIdentifier The columnIdentifier.
	 * @param Tx_PtExtlist_Domain_Model_List_Row $data The table data.
	 * @param int $columnIndex Current column index.
	 * @param int $rowIndex Current row index.
	 * 
	 * @return Tx_Pt_extlist_Domain_Model_List_Cell
	 */
	public function renderCell(Tx_PtExtlist_Domain_Configuration_ColumnConfigInterface $columnConfig, Tx_PtExtlist_Domain_Model_List_Row $data, $columnIndex, $rowIndex) {
		
		// Load all available fields
		$fieldSet = $this->createFieldSet($data, $columnConfig);

		$content = Tx_PtExtlist_Utility_RenderValue::renderByConfigObject($fieldSet, $columnConfig);
		
		// Create new cell 
		$cell = new Tx_PtExtlist_Domain_Model_List_Cell($content);
		$cell->setRowIndex($rowIndex);
		$cell->setColumnIndex($columnIndex);
		
		
		// render cell css class
		if($columnConfig->getCellCSSClass()) {
			$cell->setCSSClass($this->renderCellCSSClass($fieldSet, $columnConfig));
		}
		
		// Resolve special cell values
		/*
		 * TODO: make something usefull here ... :)
		 * 
		if($this->renderSpecialCellUserFunc || $columnConfig->getSpecialCell()) {
			$this->renderSpecialValues($cell, $columnConfig);	
		 }
		*/
		
		return $cell;
	}
	
	
	
	/**
	 * render the cells CSS Class
	 * 
	 * @param array $cell
	 * @param Tx_PtExtlist_Domain_Configuration_ColumnConfigInterface $columnConfig
	 * @return string
	 */
	protected function renderCellCSSClass($fieldSet, Tx_PtExtlist_Domain_Configuration_ColumnConfigInterface $columnConfig) {
		$cellCSSConfig = $columnConfig->getCellCSSClass();
		
		if(is_array($cellCSSConfig)) {
			$renderObj = 			array_key_exists('renderObj', $cellCSSConfig) 			? Tx_Extbase_Utility_TypoScript::convertPlainArrayToTypoScriptArray(array('renderObj' => $cellCSSConfig['renderObj'])) : NULL;
			$renderUserFunction = 	array_key_exists('renderUserFunction', $cellCSSConfig) 	? $cellCSSConfig['renderUserFunction'] : NULL;
			
			return Tx_PtExtlist_Utility_RenderValue::render($fieldSet, $renderObj, $renderUserFunction);
		} else {
			return $cellCSSConfig;
		}
	}
	
	
	
	/**
	 * Call user functions for building special values.
	 * renderer.specialCell gets overridden by column.specialCell
	 * 
	 * @param Tx_PtExtlist_Domain_Model_List_Cell &$cell
	 * @param Tx_PtExtlist_Domain_Configuration_Columns_ColumnConfig &$columnConfig
	 */
	protected function renderSpecialValues(Tx_PtExtlist_Domain_Model_List_Cell $cell, Tx_PtExtlist_Domain_Configuration_ColumnConfigInterface $columnConfig) {

		$rendererUserFunc = $this->rendererConfiguration->getSpecialCell();
				
		if(!is_null($columnConfig->getSpecialCell())) {
			$rendererUserFunc = $columnConfig->getSpecialCell();
		}
		
		if(!empty($rendererUserFunc)) {

			$dummRef = '';			
			$specialValues = t3lib_div::callUserFunction($rendererUserFunc, $cell, $dummRef);
			
			$cell->setSpecialValues($specialValues);
		}
	}
		
	
	
	/**
	 * Creates a set of fields which are available. Defined by the 'fields' TS setup.
	 *
	 * @param Tx_PtExtlist_Domain_Model_List_Row $row
	 * @return array
	 */
	protected function createFieldSet(Tx_PtExtlist_Domain_Model_List_Row $row, Tx_PtExtlist_Domain_Configuration_ColumnConfigInterface $columnConfig) {
		$fieldSet = array();
		foreach($columnConfig->getFieldIdentifier() as $fieldConfig) {
			$fieldIdentifier = (string) $fieldConfig;
			$fieldSet[$fieldIdentifier] = $row->getCell($fieldIdentifier)->getValue();	
		}	

		if($columnConfig->getContainsArrayData()) {
			$fieldSet = $this->createArrayDataFieldSet($fieldSet);				
		}
		
		return $fieldSet;
	}
	
	
	
	/**
	 * Create an array data fieldset from an array column
	 * 1. Search for first field with array data
	 * 2. Loop through this data 
	 *  2a add the data of other array fields to the output data
	 *  2b duplicate non array fields
	 *   
	 * @param array fieldSet
	 */
	protected function createArrayDataFieldSet(array $fieldSet) {
				
		foreach($fieldSet as $field) {
			if(is_array($field)) {
				$loopArray = $field;
			}
		}
		
		if(!is_array($loopArray)) throw new Exception('Error Column with Flag "containsArrayData" contains no Field with array-value! 1283426460');	
		
		$outDataArray = array();

		foreach($loopArray as $index => $value) {
			foreach($fieldSet as $fieldIdentifier => $field) {
				if(is_array($field)) {
					$outDataArray[$index][$fieldIdentifier] = $field[$index];
				} else {
					$outDataArray[$index][$fieldIdentifier] = $field;
				}
			}
		}
		
		return $outDataArray;
	}
	
}

?>