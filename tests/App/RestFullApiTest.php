<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder;

use ARFinder\Test\TestCase;
use ARFinder\App\RestFullApi;
use ARFinder\Builders\RestFullApiBuilder;

class RestFullApiTest extends TestCase {

	/**
	 * @var Instance builder data to restfull api.
	 */
	private $builderRestFullApi;

	/**
	 * Setup test environment.
	 */
	public function setUp() {

		// Instantiate data builder restfull api.
		$this->restFullApiBuilder = new RestFullApiBuilder();

		// Call parent method.
		parent::setUp();
	}

	/**
	 * @expectedException           Exception
	 * @expectedExceptionMessage 	Foi informada uma requisição vazia para a api
	 */
	public function testWhenInstantiateApiWithEmptyRequestThrowsException()
	{
		$this->restFullApiBuilder->existsRequest(false);
		$restFullApi = $this->restFullApiBuilder->create();
	}

	public function testWhenInstantiateApiWithoutVariableRequisitionGetDefaultValueAjax()
	{
		$this->restFullApiBuilder->existsRequest(true);
		$this->restFullApiBuilder->setVariableRequest('doesnotMatter', 'anyValue');
		$restFullApi = $this->restFullApiBuilder->create();

		$requestList = $restFullApi->getRequest();
		$this->assertEquals('ajax', $requestList['requisition']);

		return $restFullApi;
	}

	/**
	 * @expectedException           Exception
	 * @expectedExceptionMessage 	Variável controller não encontrada na requisição
	 */
	public function testApiExecuteRequestWithoutVariableControllerThrowsException()
	{
		$this->restFullApiBuilder->existsRequest(true);
		$this->restFullApiBuilder->setVariableRequest('doesnotMatter', 'anyValue');
		$restFullApi = $this->restFullApiBuilder->create();

		$restFullApi->executeRequest();
	}

	/**
	 * @expectedException           Exception
	 * @expectedExceptionMessage 	Variável task não encontrada na requisição
	 */
	public function testApiExecuteRequestWithoutVariableTaskThrowsException()
	{
		$this->restFullApiBuilder->existsRequest(true);
		$this->restFullApiBuilder->setVariableRequest('controller', 'anyValue');
		$restFullApi = $this->restFullApiBuilder->create();

		$restFullApi->executeRequest();
	}

}

?>
