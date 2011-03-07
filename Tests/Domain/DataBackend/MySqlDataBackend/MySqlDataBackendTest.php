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
 * Testcase for mysql data backend 
 * 
 * @author Daniel Lienert 
 * @author Michael Knoll 
 * @package Tests
 * @subpackage Domain\DataBackend\MySqlDataBackend
 */
class Tx_PtExtlist_Tests_Domain_DataBackend_MySqlDataBackend_testcase extends Tx_PtExtlist_Tests_Domain_DataBackend_AbstractDataBackendBaseTest {

	public function testSetUp() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
	}
	
	
	
	public function testInjectBackendConfiguration() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
		$dataBackend->injectBackendConfiguration($this->configurationBuilder->buildDataBackendConfiguration());
	}
	
	
	
	public function testInjectDataMapper() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
		$dataMapperMock = $this->getMock('Tx_PtExtlist_Domain_DataBackend_Mapper_ArrayMapper', array(), array($this->configurationBuilder));
		$dataBackend->injectDataMapper($dataMapperMock);
	}
	
	
	
	public function testInjectDataSource() {
        $dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
        $dataSourceMock = $this->getMock('Tx_PtExtlist_Domain_DataBackend_DataSource_MySqlDataSource', 
        								 array('executeQuery'), 
        								 array(new Tx_PtExtlist_Domain_Configuration_DataBackend_DataSource_DatabaseDataSourceConfiguration($this->configurationBuilder->buildDataBackendConfiguration()->getDataSourceSettings())
        								 	)
        								 );
		$dataBackend->injectDataSource($dataSourceMock);
	}
	
	
	
	public function testInjectFilterboxCollection() {
        $dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
        $filterBoxCollectionMock = new Tx_PtExtlist_Domain_Model_Filter_FilterboxCollection($this->configurationBuilder);
		$dataBackend->injectfilterboxCollection($filterBoxCollectionMock);
	}
	
	
	
	public function testInjectPager() {
        $dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
        

        $pagerCollectionMock = $this->getMock('Tx_PtExtlist_Domain_Model_Pager_PagerCollection', array('isEnabled', 'getCurrentPage', 'getItemsPerPage'), array(),'',FALSE);
        $pagerCollectionMock->expects($this->any())->method('isEnabled')->will($this->returnValue(true));
        $pagerCollectionMock->expects($this->any())->method('getCurrentPage')->will($this->returnValue(1));
        $pagerCollectionMock->expects($this->any())->method('getItemsPerPage')->will($this->returnValue(1));
        

		$dataBackend->injectPagerCollection($pagerCollectionMock);
	}
	
	
	
	public function testInjectQueryInterpreter() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
		$queryInterpreterMock = $this->getMock('Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlInterpreter_MySqlInterpreter');
		$dataBackend->injectQueryInterpreter($queryInterpreterMock);
	}
	
	
	
	public function testBuildFromPart() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
		$dataBackend->injectBackendConfiguration($this->configurationBuilder->buildDataBackendConfiguration());
		$dataBackend->init();
		$fromPart = $dataBackend->buildFromPart();
		$this->assertEquals($fromPart, 
							$this->tsConfig['plugin']['tx_ptextlist']['settings']['listConfig']['list1']['backendConfig']['tables'],
							'Test expected . ' .$this->tsConfig['plugin']['tx_ptextlist']['settings']['listConfig']['list1']['backendConfig']['tables'] . ' but recieved ' . $fromPart
		);
	}
	
	
	public function testBuildFromPartWitBaseFromClause() {
		$tsConfig = $this->tsConfig;
		$tsConfig['plugin']['tx_ptextlist']['settings']['listConfig']['list2'] = $this->tsConfig['plugin']['tx_ptextlist']['settings']['listConfig']['list1'];
		$tsConfig['plugin']['tx_ptextlist']['settings']['listConfig']['list2']['backendConfig']['baseFromClause'] = 'static_countries';
		$tsConfig['plugin']['tx_ptextlist']['settings']['listIdentifier'] = 'list2';
		
		Tx_PtExtlist_Domain_Configuration_ConfigurationBuilderFactory::injectSettings($tsConfig['plugin']['tx_ptextlist']['settings']);
		$configurationBuilder = Tx_PtExtlist_Domain_Configuration_ConfigurationBuilderFactory::getInstance('list2');
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($configurationBuilder);
		$dataBackend->injectBackendConfiguration($configurationBuilder->buildDataBackendConfiguration());
		$dataBackend->init();
		$fromPart = $dataBackend->buildFromPart();
		$this->assertEquals($fromPart, 
							$tsConfig['plugin']['tx_ptextlist']['settings']['listConfig']['list2']['backendConfig']['baseFromClause'],
							'Test expected . ' .$tsConfig['plugin']['tx_ptextlist']['settings']['listConfig']['list2']['backendConfig']['baseFromClause'] . ' but recieved ' . $fromPart
		);
	}
	
	
	
	public function testGetBaseWhereClause() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
		$dataBackend->injectBackendConfiguration($this->configurationBuilder->buildDataBackendConfiguration());
		$dataBackend->init();
		$baseWhereClause = $dataBackend->getBaseWhereClause();
		$this->assertTrue($baseWhereClause == $this->tsConfig['plugin']['tx_ptextlist']['settings']['listConfig']['list1']['backendConfig']['baseWhereClause']);
	}
	
	
	
	public function testGetWhereClauseFromFilter() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
		$dataBackend->injectQueryInterpreter(new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlInterpreter_MySqlInterpreter());
		
		$filterMock = $this->getFilterMockByCriteria(new Tx_PtExtlist_Domain_QueryObject_SimpleCriteria('test', 10, '>'));
		
		$filterWhereClause = $dataBackend->getWhereClauseFromFilter($filterMock);
		$this->assertTrue($filterWhereClause == 'test > "10"', 'Filter where clause was expected to be "test > 10" but was ' . $filterWhereClause);
	}
	
	
	
	public function testGetWhereClauseFromFilterWithoutActiveFilter() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
		$dataBackend->injectQueryInterpreter(new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlInterpreter_MySqlInterpreter());
		
		$filterMock = $this->getFilterMockByCriteria();
		
		$filterWhereClause = $dataBackend->getWhereClauseFromFilter($filterMock);
		$this->assertTrue($filterWhereClause == '', 'Filter where clause was expected to be "" but was ' . $filterWhereClause);
	}
	
	
	
	public function testGetWhereClauseFromFilterbox() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
        $dataBackend->injectQueryInterpreter(new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlInterpreter_MySqlInterpreter());
        
        $filter1Mock = $this->getFilterMockByCriteria(new Tx_PtExtlist_Domain_QueryObject_SimpleCriteria('test', 10, '>'));
        $filter2Mock = $this->getFilterMockByCriteria(new Tx_PtExtlist_Domain_QueryObject_SimpleCriteria('test', 10, '<'));
            
        $filterBox = $this->getFilterboxByArrayOfFilters(array($filter1Mock, $filter2Mock));

        $whereClauseFromFilterbox = $dataBackend->getWhereClauseFromFilterbox($filterBox);
        $this->assertTrue($whereClauseFromFilterbox == '(test > "10") AND (test < "10")', 'Where clause from filterbox was expected to be "(test > 10) AND (test < 10)" but was ' . $whereClauseFromFilterbox);
	}
	
	
	
	public function testGetWhereClauseFromFilterboxCollection() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
        $dataBackend->injectQueryInterpreter(new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlInterpreter_MySqlInterpreter());
		
		$filter1Mock = $this->getFilterMockByCriteria(new Tx_PtExtlist_Domain_QueryObject_SimpleCriteria('test', 10, '>'));
        $filter2Mock = $this->getFilterMockByCriteria(new Tx_PtExtlist_Domain_QueryObject_SimpleCriteria('test', 10, '<'));
        $filter3Mock = $this->getFilterMockByCriteria(new Tx_PtExtlist_Domain_QueryObject_SimpleCriteria('test', 20, '>'));
        $filter4Mock = $this->getFilterMockByCriteria(new Tx_PtExtlist_Domain_QueryObject_SimpleCriteria('test', 20, '<'));
        
        $filterbox1 = $this->getFilterboxByArrayOfFilters(array($filter1Mock, $filter2Mock));
        $filterbox2 = $this->getFilterboxByArrayOfFilters(array($filter3Mock, $filter4Mock));
        
        $filterboxCollection = new Tx_PtExtlist_Domain_Model_Filter_FilterboxCollection($this->configurationBuilder);
        $filterboxCollection->addItem($filterbox1);
        $filterboxCollection->addItem($filterbox2);
        
        $dataBackend->injectfilterboxCollection($filterboxCollection);
        $whereClauseForFilterboxCollection = $dataBackend->getWhereClauseFromFilterboxes();
        $this->assertTrue($whereClauseForFilterboxCollection == '((test > "10") AND (test < "10")) AND ((test > "20") AND (test < "20"))', 'Where clause for filterbox collection should have been "((test > 10) AND (test < 10)) AND ((test > 20) AND (test < 20))" but was ' . $whereClauseForFilterboxCollection);
        
	}
	
	
	
	public function testGetLimitPart() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
        $dataBackend->injectQueryInterpreter(new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlInterpreter_MySqlInterpreter());

        $pagerCollectionMock = $this->getMock('Tx_PtExtlist_Domain_Model_Pager_PagerCollection', array('isEnabled', 'getCurrentPage', 'getItemsPerPage'), array($this->configurationBuilder));
        $pagerCollectionMock->expects($this->any())
            ->method('getCurrentPage')
            ->will($this->returnValue(10));
        $pagerCollectionMock->expects($this->any())
            ->method('getItemsPerPage')
            ->will($this->returnValue(10));
        $pagerCollectionMock->expects($this->once())
            ->method('isEnabled')
            ->will($this->returnValue(true));
        
        $dataBackend->injectPagerCollection($pagerCollectionMock);
            
        $limitPart = $dataBackend->buildLimitPart();
        $this->assertTrue($limitPart == '90,10', 'Limit part of pager was expected to be 90,10 but was ' . $limitPart);
	}
	
	
	
	public function testBuildSelectPartWithTableAndField() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
        $dataBackend->injectQueryInterpreter(new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlInterpreter_MySqlInterpreter());

        $fieldConfigurationCollection = new Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfigCollection();
        $fieldConfigurationCollection->addItem($this->getFieldConfigMockForTableAndFieldAndIdentifier('table1', 'field1', 'test1'));
        $fieldConfigurationCollection->addItem($this->getFieldConfigMockForTableAndFieldAndIdentifier('table1', 'field2', 'test2'));
        $dataBackend->injectFieldConfigurationCollection($fieldConfigurationCollection);
        
        $selectPartForFieldConfigurationCollection = $dataBackend->buildSelectPart();
        
        $expectedSelectPart = Tx_PtExtlist_Utility_DbUtils::getAliasedSelectPartByFieldConfig($fieldConfigurationCollection[0]) . ', ' .
            Tx_PtExtlist_Utility_DbUtils::getAliasedSelectPartByFieldConfig($fieldConfigurationCollection[1]);
        
        $this->assertTrue($selectPartForFieldConfigurationCollection == $expectedSelectPart, 
            'Select part for field configuration collection should be "' . $expectedSelectPart . '" but was ' . $selectPartForFieldConfigurationCollection);
	}
	
	
	
	
	public function testBuildSelectPartWithSpecialString() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
        $dataBackend->injectQueryInterpreter(new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlInterpreter_MySqlInterpreter());

        $fieldConfigurationCollection = new Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfigCollection();
        $fieldConfigurationCollection->addItem($this->getFieldConfigMockForSpecialAndIdentifier('specialString', 'testFieldIdentifier'));
        $dataBackend->injectFieldConfigurationCollection($fieldConfigurationCollection);
        
        $selectPartForFieldConfigurationCollection = $dataBackend->buildSelectPart();
        
        $expectedSelectPart = '(specialString) AS testFieldIdentifier';
        
        $this->assertTrue($selectPartForFieldConfigurationCollection == $expectedSelectPart, 
            'Select part for field configuration collection should be "' . $expectedSelectPart . '" but was ' . $selectPartForFieldConfigurationCollection);
	}
	
	
	
	public function testGetListData() {
		$dataSourceReturnArray = array(
            array('t1.f1' => 'v1_1', 't1.f2' => 'v1_2', 't1.f3' => 'v1_3','t2.f1' => 'v1_4', 't2.f2' => 'v1_5'),
            array('t1.f1' => 'v2_1', 't1.f2' => 'v2_2', 't1.f3' => 'v2_3','t2.f1' => 'v2_4', 't2.f2' => 'v2_5'),
            array('t1.f1' => 'v3_1', 't1.f2' => 'v3_2', 't1.f3' => 'v3_3','t2.f1' => 'v3_4', 't2.f2' => 'v3_5'),
            array('t1.f1' => 'v4_1', 't1.f2' => 'v4_2', 't1.f3' => 'v4_3','t2.f1' => 'v4_4', 't2.f2' => 'v4_5'),
            array('t1.f1' => 'v5_1', 't1.f2' => 'v5_2', 't1.f3' => 'v5_3','t2.f1' => 'v5_4', 't2.f2' => 'v5_5'),
            array('t1.f1' => 'v6_1', 't1.f2' => 'v6_2', 't1.f3' => 'v6_3','t2.f1' => 'v6_4', 't2.f2' => 'v6_5'),
            array('t1.f1' => 'v7_1', 't1.f2' => 'v7_2', 't1.f3' => 'v7_3','t2.f1' => 'v7_4', 't2.f2' => 'v7_5'),
            array('t1.f1' => 'v8_1', 't1.f2' => 'v8_2', 't1.f3' => 'v8_3','t2.f1' => 'v8_4', 't2.f2' => 'v8_5'),
        );

        $dataSourceMock = $this->getMock('Tx_PtExtlist_Domain_DataBackend_DataSource_MySqlDataSource', 
        									array('executeQuery'), 
        									array(new Tx_PtExtlist_Domain_Configuration_DataBackend_DataSource_DatabaseDataSourceConfiguration($this->configurationBuilder->buildDataBackendConfiguration()->getDataBackendSettings())));
        $dataSourceMock->expects($this->once())
            ->method('executeQuery')
            ->will($this->returnValue($dataSourceReturnArray));
            
       
        $pagerCollectionMock = $this->getMock('Tx_PtExtlist_Domain_Model_Pager_PagerCollection', array('isEnabled', 'getCurrentPage', 'getItemsPerPage'), array($this->configurationBuilder));
        $pagerCollectionMock->expects($this->any())
            ->method('getCurrentPage')
            ->will($this->returnValue(10));
        $pagerCollectionMock->expects($this->any())
            ->method('getItemsPerPage')
            ->will($this->returnValue(10));
        $pagerCollectionMock->expects($this->once())
            ->method('isEnabled')
            ->will($this->returnValue(true));

        $listHeaderMock = $this->getListHeaderByFieldAndDirectionArray(array('name' => Tx_PtExtlist_Domain_QueryObject_Query::SORTINGSTATE_ASC,
        																'company' => Tx_PtExtlist_Domain_QueryObject_Query::SORTINGSTATE_DESC));
            
        $mapperMock = $this->getMock('Tx_PtExtlist_Domain_DataBackend_Mapper_ArrayMapper', array(), array($this->configurationBuilder));
        $mapperMock->expects($this->once())
            ->method('getMappedListData')
            ->will($this->returnValue($dataSourceReturnArray));
            
                
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
		$dataBackend->injectBackendConfiguration($this->configurationBuilder->buildDataBackendConfiguration());
        $dataBackend->injectQueryInterpreter(new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlInterpreter_MySqlInterpreter());
        $dataBackend->injectDataSource($dataSourceMock);
        $dataBackend->injectPagerCollection($pagerCollectionMock);
        $dataBackend->injectDataMapper($mapperMock);
		$dataBackend->injectListHeader($listHeaderMock);
        $dataBackend->init();
        
        $listData = $dataBackend->getListData();
        $this->assertTrue($listData == $dataSourceReturnArray);
	}
	
	
	public function testListDataCacheWorks() {
		$dataBackend = $this->getAccessibleMock('Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend', array('buildListData'), array($this->configurationBuilder));
		$dataBackend->expects($this->once())
            ->method('buildListData');
            
        $dataBackend->getListData();
        $dataBackend->_set('listData', array());
        
        $dataBackend->getListData();
	}
	
	
	public function testListDataCanBeResetted() {
		$dataBackend = $this->getAccessibleMock('Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend', array('buildListData'), array($this->configurationBuilder));
		$dataBackend->expects($this->exactly(2))
            ->method('buildListData');
            
        $dataBackend->getListData();
        $dataBackend->_set('listData', array());
        $dataBackend->_set('listQueryParts', array());
        
        $dataBackend->resetListDataCache();
		$this->assertEquals($dataBackend->_get('listQueryParts'), NULL);
        
		$dataBackend->getListData();
	}
	
	
	public function testGetOrderByFromListHeader() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
        $dataBackend->injectQueryInterpreter(new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlInterpreter_MySqlInterpreter());
        
        $listHeaderMock = $this->getListHeaderByFieldAndDirectionArray(array('name' => Tx_PtExtlist_Domain_QueryObject_Query::SORTINGSTATE_ASC,
        																'company' => Tx_PtExtlist_Domain_QueryObject_Query::SORTINGSTATE_DESC));
        
        $orderByString = $dataBackend->getOrderByFromListHeader($listHeaderMock);
        
		$this->assertEquals($orderByString, 'name ASC, company DESC', 'getOrderByFromListHeader expected to be "name ASC, company DESC", was ' . $orderByString);
	}
	
	
	
	public function testGetOrderByFromHeaderColumn() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
        $dataBackend->injectQueryInterpreter(new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlInterpreter_MySqlInterpreter());
        
        $headerMock = $this->getHeaderColumnBySortingFieldAndDirection('name', Tx_PtExtlist_Domain_QueryObject_Query::SORTINGSTATE_ASC);
        $orderByString = $dataBackend->getOrderByFromHeaderColumn($headerMock);
        
        
        $this->assertEquals($orderByString, 'name ASC', 'getOrderByFromHeaderColumn expected to be "name ASC", was ' . $orderByString);
	}
	
	
	
	public function testGetGroupData() {
		$dataBackend = new Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend($this->configurationBuilder);
		
		$fields = array('field1', 'field2', 'field3');
		$excludeFilters = array('filterbox1.filter1', 'filterbox1.filter2', 'filterbox2.filter1');
		$additionalQuery = new Tx_PtExtlist_Domain_QueryObject_Query();
		$additionalQuery->addCriteria(Tx_PtExtlist_Domain_QueryObject_Criteria::greaterThan('field1', 10));
		
		$returnArray = array('test');
		$listHeader = Tx_PtExtlist_Domain_Model_List_Header_ListHeaderFactory::createInstance($this->configurationBuilder);
		
		$queryInterpreterMock = $this->getMock('Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlInterpreter_MySqlInterpreter',array('interpretQuery'), array(), '', FALSE);
        $dataSourceMock = $this->getMock('Tx_PtExtlist_Domain_DataBackend_DataSource_MySqlDataSource', array('executeQuery'), array(), '', FALSE);
        $dataSourceMock->expects($this->once())->method('executeQuery')->will($this->returnValue($returnArray));
        
        $dataBackend->injectBackendConfiguration($this->configurationBuilder->buildDataBackendConfiguration());
        $dataBackend->injectPagerCollection(Tx_PtExtlist_Domain_Model_Pager_PagerCollectionFactory::getInstance($this->configurationBuilder));
	    $dataBackend->injectDataSource($dataSourceMock);
		$dataBackend->injectQueryInterpreter($queryInterpreterMock);
		$dataBackend->injectListHeader($listHeader);
		$dataBackend->init();
		
		$groupData = $dataBackend->getGroupData($additionalQuery, $excludeFilters);
		$this->assertEquals($returnArray, $groupData);
	}
	
	
	
	public function testCreateDataSource() {
		/* PROBLEM: PDO is not installed on devel server */
		// hint: Database parameters are taken from current T3 database configuration
		#$dataSource = Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend::createDataSource($this->configurationBuilder);
		#$this->assertTrue(is_a($dataSource, 'Tx_PtExtlist_Domain_DataBackend_DataSource_MySqlDataSource'));
	}

	
	public function testConvertTableFieldToAlias() {
		$accessibleClassName = $this->buildAccessibleProxy('Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend');
		$dataBackend = new $accessibleClassName($this->configurationBuilder);
		$dataBackend->injectFieldConfigurationCollection($this->configurationBuilder->buildFieldsConfiguration());
		
		$strings[] = array('test' => 'table1.field1 AS fieldIndentifier1', 'return' =>'fieldIndentifier1'); 
		$strings[] = array('test' => '(someSepcial table1.field1) AS SpecialIdentifier', 'return' =>'(someSepcial fieldIndentifier1) AS SpecialIdentifier'); 
		$strings[] = array('test' => 'GROUP BY table1.field1', 'return' =>'GROUP BY fieldIndentifier1'); 
		
		foreach($strings as $string) {
			$returnString = $dataBackend->_call('convertTableFieldToAlias', $string['test']);
			$this->assertEquals($string['return'], $returnString, 'Mangled string is not as excepted : ' . $returnString . ' is not ' . $string['return']);
		}
	}
	
	
	public function testBuildQuery() {
		$this->markTestIncomplete();
	}
	
	
	
	public function testBuildWherePart() {
		$this->markTestIncomplete();
	}
	
	
	
	public function testBuildOrderByPart() {
		$this->markTestIncomplete();
	}
	
	
	
	public function testGetTotalItemsCount() {
		$this->markTestIncomplete();
	}
	
	
	public function testGetGroupByPart() {
		$dataBackend = $this->getDataBackend();
		$groupByPart = $dataBackend->buildGroupByPart();
		$this->assertEquals($groupByPart, 'company');
	}
	
	
	public function testGetAggregatesByConfigCollection() {
		$configOverwrite['listConfig']['test']['aggregateData']['sumField1']['scope'] = 'query';
		$configurationBuilderMock = Tx_PtExtlist_Tests_Domain_Configuration_ConfigurationBuilderMock::getInstance(NULL, $configOverwrite);
		$aggConfigCollection = Tx_PtExtlist_Domain_Configuration_Data_Aggregates_AggregateConfigCollectionFactory::getInstance($configurationBuilderMock);
		$dataBackend = $this->getDataBackend($configurationBuilderMock);
		
		$this->assertEquals('SUM(field1) AS sumField1', $dataBackend->_call('buildAggregateFieldSQLByConfig', $aggConfigCollection->getAggregateConfigByIdentifier('sumField1')));
	}
	
	
	public function testGetAggregatesByConfigCollectionWithUnsopportedMethod() {
		$configOverwrite['listConfig']['test']['aggregateData']['sumField1'] = array('scope' => 'query', 'method' => 'aNotExistantMethod');
		$configurationBuilderMock = Tx_PtExtlist_Tests_Domain_Configuration_ConfigurationBuilderMock::getInstance(NULL, $configOverwrite);
		$aggConfigCollection = Tx_PtExtlist_Domain_Configuration_Data_Aggregates_AggregateConfigCollectionFactory::getInstance($configurationBuilderMock);
		$dataBackend = $this->getDataBackend($configurationBuilderMock);
		
		try {
			$dataBackend->_call('buildAggregateFieldSQLByConfig', $aggConfigCollection->getAggregateConfigByIdentifier('sumField1'));
		} catch (Exception $e) {
			return;
		}
		
		$this->fail('No Exception thrown if Method is unsupported');
	}
	
	
	public function testGetAggregatesByConfigCollectionWithSpecialString() {
		$configOverwrite['listConfig']['test']['aggregateData']['sumField1'] = array('scope' => 'query', 'special' => 'special');
		$configurationBuilderMock = Tx_PtExtlist_Tests_Domain_Configuration_ConfigurationBuilderMock::getInstance(NULL, $configOverwrite);
		$aggConfigCollection = Tx_PtExtlist_Domain_Configuration_Data_Aggregates_AggregateConfigCollectionFactory::getInstance($configurationBuilderMock);
		$dataBackend = $this->getDataBackend($configurationBuilderMock);
		
		$this->assertEquals('special AS sumField1', $dataBackend->_call('buildAggregateFieldSQLByConfig', $aggConfigCollection->getAggregateConfigByIdentifier('sumField1')));
	}
	
	
	
	public function testBuildAggregateSqlByConfigCollection() {
		$configOverwrite['listConfig']['test']['aggregateData']['sumField1'] = array('scope' => 'query', 'special' => 'special');
		$configurationBuilderMock = Tx_PtExtlist_Tests_Domain_Configuration_ConfigurationBuilderMock::getInstance(NULL, $configOverwrite);
		$aggConfigCollection = Tx_PtExtlist_Domain_Configuration_Data_Aggregates_AggregateConfigCollectionFactory::getInstance($configurationBuilderMock);
		$dataBackend = $this->getDataBackend($configurationBuilderMock);
		
		$sql = $dataBackend->_call('buildAggregateSQLByConfigCollection', $aggConfigCollection);

		$this->assertEquals('SELECT special AS sumField1, AVG(field2) AS avgField2 
 FROM (SELECT tableName1.fieldName1 AS field1, tableName2.fieldName2 AS field2, (special) AS field3, tableName4.fieldName4 AS field4 
FROM companies 
WHERE employees > 0 
GROUP BY company 
)  AS AGGREGATEQUERY', $sql);
	}
	
	
	/**********************************************************************************************************************************************************
	 * Helper methods 
	 **********************************************************************************************************************************************************/
	
	protected function getDataBackend($configurationBuilderMock = NULL) {
		
		if(!is_a($configurationBuilderMock, 'Tx_PtExtlist_Tests_Domain_Configuration_ConfigurationBuilderMock')) {
			$configurationBuilderMock = Tx_PtExtlist_Tests_Domain_Configuration_ConfigurationBuilderMock::getInstance();	
		}
		
		$dataBackendAccessible = $this->buildAccessibleProxy('Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlDataBackend');
		$dataBackend = new $dataBackendAccessible($configurationBuilderMock);
				
		$queryInterpreterMock = $this->getMock('Tx_PtExtlist_Domain_DataBackend_MySqlDataBackend_MySqlInterpreter_MySqlInterpreter',array('interpretQuery'), array(), '', FALSE);
        $dataSourceMock = $this->getMock('Tx_PtExtlist_Domain_DataBackend_DataSource_MySqlDataSource', array('executeQuery'), array(), '', FALSE);

        $listHeader = Tx_PtExtlist_Domain_Model_List_Header_ListHeaderFactory::createInstance($configurationBuilderMock);
        $pagerCollection = Tx_PtExtlist_Domain_Model_Pager_PagerCollectionFactory::getInstance($configurationBuilderMock);
        
        $dataBackend->injectBackendConfiguration($configurationBuilderMock->buildDataBackendConfiguration());
	    $dataBackend->injectDataSource($dataSourceMock);
		$dataBackend->injectQueryInterpreter($queryInterpreterMock);
		$dataBackend->injectFieldConfigurationCollection($configurationBuilderMock->buildFieldsConfiguration());
		$dataBackend->injectPagerCollection($pagerCollection);        
		$dataBackend->injectListHeader($listHeader);
		
		$dataBackend->init();
		
		return $dataBackend;
	}
	
	protected function getFieldConfigMockForTableAndFieldAndIdentifier($table, $field, $identifier) {
		$fieldConfigurationMock = $this->getMock('Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig', array(), array($this->configurationBuilder,$identifier, array('table' => $table, 'field' => $field)));
        $fieldConfigurationMock->expects($this->any())
            ->method('getTable')
            ->will($this->returnValue($table));
        $fieldConfigurationMock->expects($this->any())
            ->method('getField')
            ->will($this->returnValue($field));
        return $fieldConfigurationMock;
	}
	
	
	protected function getFieldConfigMockForSpecialAndIdentifier($special, $identifier) {
		$fieldConfigurationMock = $this->getMock('Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig', array(), array($this->configurationBuilder,$identifier, array('special' => $special)));
        $fieldConfigurationMock->expects($this->any())
            ->method('getSpecial')
            ->will($this->returnValue($special));
        $fieldConfigurationMock->expects($this->any())
            ->method('getIdentifier')
            ->will($this->returnValue($identifier));
        return $fieldConfigurationMock;
	}
	
	
	protected function getFilterboxByArrayOfFilters($filtersArray) {
		$filterBoxConfiguration = new Tx_PtExtlist_Domain_Configuration_Filters_FilterboxConfig($this->configurationBuilder, 'test', array());
        $filterBox = new Tx_PtExtlist_Domain_Model_Filter_Filterbox($filterBoxConfiguration);
        foreach($filtersArray as $filter) {
        	$filterBox->addItem($filter);
        }
        return $filterBox;
	}
	
	
	
	protected function getFilterMockByCriteria($criteria = NULL) {
		$filterQuery = new Tx_PtExtlist_Domain_QueryObject_Query();
        
		if($criteria != NULL) {
        	$filterQuery->addCriteria($criteria);	
        }
		
        $filterMock = $this->getMock('Tx_PtExtlist_Domain_Model_Filter_StringFilter', array('getFilterQuery'));
        $filterMock->expects($this->once())
            ->method('getFilterQuery')
            ->will($this->returnValue($filterQuery));
        return $filterMock;
	}
	
	
	
	protected function getHeaderColumnBySortingFieldAndDirection($field, $direction) {
		$sortingQuery = new Tx_PtExtlist_Domain_QueryObject_Query();
        $sortingQuery->addSorting($field, $direction);
        $headerMock = $this->getMock('Tx_PtExtlist_Domain_Model_List_Header_HeaderColumn', array('getSortingQuery'));
        $headerMock->expects($this->once())
            ->method('getSortingQuery')
            ->will($this->returnValue($sortingQuery));
        return $headerMock;
	}
	
	
	
	protected function getListHeaderByFieldAndDirectionArray($fieldAndDirectionArray) {
		$listHeader = new Tx_PtExtlist_Domain_Model_List_Header_ListHeader();
		
		foreach($fieldAndDirectionArray as $field => $direction) {
			$sortingQuery = new Tx_PtExtlist_Domain_QueryObject_Query();
        	$sortingQuery->addSorting($field, $direction);
        	
        	$headerMock = $this->getMock('Tx_PtExtlist_Domain_Model_List_Header_HeaderColumn', array('getSortingQuery'));
        	$headerMock->expects($this->once())
            ->method('getSortingQuery')
            ->will($this->returnValue($sortingQuery));
            
         	$listHeader->addHeaderColumn($headerMock, $field);   
		}
		
		return $listHeader;
	}

    	
}

?>