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
 * Class implements a cell of a row of list data
 * 
 * @package Domain
 * @subpackage Model\List
 * @author Michael Knoll 
 * @author Christoph Ehscheidt 
 * @author Daniel Lienert 
 */
class Tx_PtExtlist_Domain_Model_List_Cell {

	/**
	 * Holds value of cell
	 *
	 * @var string
	 */
	protected $value;
	
	
	
	/**
	 * Special values for multiple purpose
	 * @var string
	 */
	protected $specialValues;
	
	
	
	/**
	 * TODO add some comment!
	 *
	 * @var int
	 */
	protected $rowIndex;
	
	
	
	/**
	 * TODO add some comment
	 *
	 * @var int
	 */
	protected $columnIndex;
	
	
	/**
	 * Individual cell class
	 * 
	 * @var string
	 */
	protected $cssClass;
	
	
	/**
	 * Constructor for cell object
	 *
	 * @param string $value
	 */
	public function __construct($value) {
		$this->value = $value;
	}
	
	
	
	/**
	 * Setter for cell value
	 *
	 * @param string $value
	 */
	public function setValue($value) {
		$this->value = $value;
	}
	
	
	
	/**
	 * Getter for cell value
	 *
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}
	
	
	
	/**
	 * Add a special value to the list
	 * @param string $key
	 * @param mixed $value
	 */
	public function addSpecialValue($key, $value) {
		$this->specialValues[$key] = $value;
	}
	
	
	
	/**
	 * Get a special value from the list
	 * @param string $key
	 */
	public function getSpecialValue($key) {
		return $this->specialValues[$key];
	}	
	
	
	
	/**
	 * Return the complete value array
	 */
	public function getSpecialValues() {
		return $this->specialValues;
	}
	
	
	
	/**
	 * Remove a special value from the list
	 * @param string $key
	 */
	public function removeSpecialValue($key) {
		unset($this->specialValues[$key]);
	}
	
	
	
	/**
	 * Setter for row index
	 *
	 * @param int $rowIndex
	 */
	public function setRowIndex($rowIndex) {
		$this->rowIndex = $rowIndex;
	}
	
	
	
	/**
	 * Getter for row index
	 *
	 * @return int
	 */
	public function getRowIndex() {
		return $this->rowIndex;
	}
	
	
	
	/**
	 * Setter for column index
	 *
	 * @param int $columnIndex
	 */
	public function setColumnIndex($columnIndex) {
		$this->columnIndex = $columnIndex;
	}
	
	
	
	/**
	 * Getter for column index
	 *
	 * @return int
	 */
	public function getColumnIndex() {
		return $this->columnIndex;
	}
	
	
	/**
	 * set the individual cell CSS class
	 * 
	 * @param string $cellCSSClass
	 */
	public function setCSSClass($cssClass) {
		$this->cssClass = $cssClass;
	}
	
	
	/**
	 * get the individual cell CSS class
	 * @return string 	 
	 */
	public function getCSSClass() {
		return $this->cssClass;
	}
	
	/**
	 * Returns object value as string
	 *
	 * @return string
	 */
	public function __toString() {
		
		if(is_string($this->value)) {
			return (string) $this->value;
		}
		
		if (is_array($this->value)) {
			return implode(',', $this->value);
		}

		if(!$this->value) return '';
		
		return 'Unknown Value';
	}
}
?>