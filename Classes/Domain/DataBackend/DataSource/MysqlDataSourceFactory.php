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
 * Class implements data source for mysql databases
 * 
 * @author Daniel Lienert <lienert@punkt.de>
 * @package Domain
 * @subpackage DataBackend\DataSource
 */
class Tx_PtExtlist_Domain_DataBackend_DataSource_MysqlDataSourceFactory  {
	
	/**
	 * 
	 * Create instance of mysql data source
	 * @param Tx_PtExtlist_Domain_Configuration_DataBackend_DataSource_DatabaseDataSourceConfiguration $dataSourceConfiguration
	 */
	public static function createInstance(Tx_PtExtlist_Domain_Configuration_DataBackend_DataSource_DatabaseDataSourceConfiguration $dataSourceConfiguration) {
		$dataSource = new Tx_PtExtlist_Domain_DataBackend_DataSource_MySqlDataSource($dataSourceConfiguration);
		$dataSource->injectDbObject(self::createDataObject($dataSourceConfiguration));
		return $dataSource;
	}
	
	/**
	 * Create Database Object
	 * 
	 * @param Tx_PtExtlist_Domain_Configuration_DataBackend_DataSource_DatabaseDataSourceConfiguration $dataSourceConfiguration
	 * @throws Exception
	 */
	protected static function createDataObject(Tx_PtExtlist_Domain_Configuration_DataBackend_DataSource_DatabaseDataSourceConfiguration $dataSourceConfiguration) {
		
		$dsn = sprintf('mysql:dbname=%s;host=%s;port=%s',
							$dataSourceConfiguration->getDatabaseName(),
							$dbHost,
							$dbPort);
							
		try {
			$pdo = new PDO($dsn, 
					$dataSourceConfiguration->getUsername(), 
					$dataSourceConfiguration->getPassword());	
		} catch (Exception $e) {
			throw new Exception('Unable to establish MYSQL Databse Connection: ' . $e->getMessage() . ' 1281215132');
		}
		
		
						
		return $pdo;
	}	
}
?>