<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder;

use ARFinder\App\Application;
use ARFinder\Builders\ApplicationBuilder;
use ARFinder\Test\TestCase;
use ARFinder\App\RestFullApi;
use ReflectionClass;
use Exception;

class ApplicationTest extends TestCase {

	/**
	 * @var Application Application.
	 */
	private $application;

	/**
	 * @var ApplicationBuilder Data builder Application.
	 */
	private $builderApplication;

	/**
	 * @var PHPUnit_Framework_MockObject_MockBuilder Mock application Text.
	 */
	private $mockApplication;

    /**
     * Full name Application class.
     * @var string
     */
    const APPLICATION_CLASS = 'ARFinder\App\Application';

	/**
	 * Setup test environment.
	 */
	public function setUp() {

        // Clear $_REQUEST variable each new tests.
        $_REQUEST = array();

		// Instantiate data builder Application.
		$this->builderApplication = new ApplicationBuilder();

        // Create an Application.
		$this->application = $this->builderApplication->getApplication();

        // Mock application.
		$this->mockApplication = $this->getMockBuilder(self::APPLICATION_CLASS);
		// Call parent method.
		parent::setUp();
	}

	/**
	 * @covers Application::__constructor
	 */
	public function testInstantiateApplicationWithoutDataRequestNotCallExecuteRequest() {
        // Get mock Application without constructor.
        $mockApplication = $this->mockApplication->disableOriginalConstructor()->getMock();

        // Checks if executeRequest not call.
        $mockApplication->expects($this->never())->method('executeRequest');

        // Call the constructor.
        $reflectedClass = new ReflectionClass(self::APPLICATION_CLASS);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mockApplication);
	}

    /**
     * @covers Application::__constructor
     */
    public function testInstantiateApplicationWithDataRequestCallExecuteRequestOnce() {
        // Get mock Application without constructor.
        $mockApplication = $this->mockApplication->disableOriginalConstructor()->getMock();

        // Populate $_REQUEST array.
        $this->builderApplication->populateRequest();

        // Checks if executeRequest not call.
        $mockApplication->expects($this->once())->method('executeRequest');

        // Call the constructor.
        $reflectedClass = new ReflectionClass(self::APPLICATION_CLASS);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mockApplication);
    }

    /**
     * @covers                          Application::executeRequest
	 * @expectedException               Exception
	 * @expectedExceptionMessageRegExp 	/Não existem dados na requisição para processamento do método \w+/
	 */
	public function testInvokeMethodExecuteRequestWithoutDataRequestThrowsException() {
        $this->application->executeRequest();
	}

    /**
     * @covers                          Application::executeRequest
	 * @expectedException               Exception
	 * @expectedExceptionMessageRegExp  /O método \w+ não pode ser processado pois não foi encotrado parâmetro obrigatório execute/
	 */
	public function testInvokeMethodExecuteRequestWithoutParamExecuteThrowsException()	{
        // Populate $_REQUEST array.
        $this->builderApplication->populateRequest();

        $this->application->executeRequest();
	}

    /**
     * @covers                         Application::executeRequest
	 * @expectedException              Exception
	 * @expectedExceptionMessageRegExp /O método \w+ não permite o valor \w*[ ]*\w+ para o parâmeto execute/
	 */
	public function testCallMethodExecuteRequestWithInvalidValueExecuteParamThrowsException() {
        // Populate $_REQUEST array.
        $this->builderApplication->populateRequest(array ('execute' => 'anyValue'));
        $this->application->executeRequest();
	}

    /**
     * @covers                         Application::getRestFullApi
	 */
    public function testGetRestFullApiAlwaysReturnInstanceOfRestFullApi() {
        $api = $this->application->getRestFullApi();
        $this->assertInstanceOf('ARFinder\App\RestFullApi', $api);
    }

}

?>
