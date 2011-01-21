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
 * Wrapper class for subcontroller. Handles requests for subcontrollers
 * and emulates dispatching functionality like forwarding etc.
 * 
 * @author Michael Knoll 
 * @package Controller
 */
class Tx_PtExtlist_Controller_SubcontrollerWrapper extends Tx_PtExtlist_Controller_AbstractController {

	/**
	 * Holds a reference of the controller to be used as subcontroller
	 *
	 * @var Tx_PtExtlist_Controller_AbstractController
	 */
	protected $subcontroller;

	
	
	/**
	 * Holds an instance of subcontroller factory to create
	 * instances of subcontrollers for forwardings etc.
	 *
	 * @var Tx_PtExtlist_Controller_SubcontrollerFactory
	 */
	protected $subcontrollerFactory;
	
	
	
	/**
	 * Holds an instance of current request that has to be processed by subcontroller
	 *
	 * @var Tx_Extbase_MVC_Web_Request
	 */
	protected $request;
	
	
	
	/**
	 * Holds an instance of current response that is manipulated by subcontroller
	 *
	 * @var Tx_Extbase_MVC_Web_Response
	 */
	protected $response;
	
	
	
	/**
	 * Injector for request
	 *
	 * @param Tx_Extbase_MVC_Web_Request $request
	 */
	public function injectRequest(Tx_Extbase_MVC_Web_Request $request) {
		$this->request = $request;
	}
	
	
	
	/**
	 * Injector for response
	 *
	 * @param Tx_Extbase_MVC_Web_Response $response
	 */
	public function injectResponse(Tx_Extbase_MVC_Web_Response $response) {
	    $this->response = $response;	
	}
	
	
	
	/**
	 * Injector for subcontroller
	 *
	 * @param Tx_PtExtlist_Controller_AbstractController $subcontroller
	 */
	public function injectSubcontroller(Tx_PtExtlist_Controller_AbstractController $subcontroller) {
		$this->subcontroller = $subcontroller;
	}
	
	
	
	/**
	 * Injector for subcontroller factory
	 *
	 * @param Tx_PtExtlist_Controller_SubcontrollerFactory $subcontrollerFactory
	 */
	public function injectSubcontrollerFactory(Tx_PtExtlist_Controller_SubcontrollerFactory $subcontrollerFactory) {
		$this->subcontrollerFactory = $subcontrollerFactory;
	}
	
	
	
	/**
	 * Magic function that handles action-calls on subcontroller wrapper.
	 * Checks whether given method name is a correct action and whether action exists in controller
	 *
	 * @param string $method Method name to be called on subcontroller
	 * @param array $args Arguments delivered for action to be called
	 */
    public function __call($method, $args) {
    	$matches = array();
    	if (!preg_match('/(.+?)Action/', $method, $matches)) {
    		throw new Exception('Given method name is not a correct action name: ' . $method . ' 1283351947');
    	}
    	tx_pttools_assert::isNotEmptyString($matches[1], array('message' => 'No action name could be parsed from ' . $method . ' 1283351949'));
    	$controllerActionname = $matches[1];
    	if (!method_exists($this->subcontroller, $method)) {
    		throw new Exception('Trying to call action ' . $method . ' on ' . get_class($this->subcontroller) . ' which does not exist! 1283351948');
    	}
    	return $this->processAction($controllerActionname, $args);
    }
    
    
    
    /**
     * Processes action called on subcontroller
     *
     * @param string $controllerActionName
     * @param array $args
     * @return string HTML source: the rendered action
     */
    protected function processAction($controllerActionName, $args) {
    	$dispatchLoopCount = 0;
    	// TODO insert arguments into request!
    	// Perhaps this works like that: $this->request->setArguments();
    	$this->request->setControllerActionName($controllerActionName);

    	while (!$this->request->isDispatched()) {
            if ($dispatchLoopCount > 0) {
            	$this->subController = $this->subcontrollerFactory->getPreparedSubController($this->request);
            }
            if ($dispatchLoopCount++ > 99) throw new Tx_Extbase_MVC_Exception_InfiniteLoop('Could not ultimately dispatch the request after '  . $dispatchLoopCount . ' iterations.', 1283351950);
            try {
                $this->subcontroller->processRequest($this->request, $this->response);
            } catch (Tx_Extbase_MVC_Exception_StopAction $ignoredException) {
            }
        }
        
        return $this->response->getContent();
    }
	
	
}