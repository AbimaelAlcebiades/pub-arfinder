<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder;

use ARFinder\Builders\SobekIntegratorBuilder;
use ARFinder\Exceptions\SobekBadXMLReturnException;
use ARFinder\Test\TestCase;
use \stdClass;

class SobekIntegratorTest extends TestCase {

	/**
	 * @var Instance Sobek Integrator.
	 */
	private $sobekIntegrator;

	/**
	 * @var Instance Data builder Sobek integrator.
	 */
	private $builderSobekIntegrator;

	/**
	 * Setup test environment.
	 */
	public function setUp() {

		// Insert applications paths.
		require_once '\..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR 
			. 'Config' . DIRECTORY_SEPARATOR . 'application_paths.php';

		// Instantiate data builder Sobek integrator.
		$this->builderSobekIntegrator = new SobekIntegratorBuilder();
		// Create an Sobek Integrator to scenario.
		$this->sobekIntegrator = $this->builderSobekIntegrator->create();
		// Call parent method.
		parent::setUp();
	}

	public function testServiceIsOnlineReturnsHttpCode200() {
		// Creat stub Sobek integrator.
		$stubSobekIntegrator = $this->getMockBuilder('ARFinder\Sobek\Integrator')->setMethods(array('getWebServiceStatus'))->getMock();

		// Set web service status online .
		$this->builderSobekIntegrator->webServiceIsOnline();

		// Manipulate returns getWebServiceStatus method.
		$stubSobekIntegrator->method('getWebServiceStatus')->willReturn($this->builderSobekIntegrator->getFakeWebServiceStatus());

		$this->assertTrue($stubSobekIntegrator->serviceIsOnline());
	}

	public function testServiceIsOfflineReturnsHttpCodeUnlike200() {
		// Creat stub Sobek integrator.
		$stubSobekIntegrator = $this->getMockBuilder('ARFinder\Sobek\Integrator')->setMethods(array('getWebServiceStatus'))->getMock();

		// Set web service status online .
		$this->builderSobekIntegrator->webServiceIsOffline();

		// Manipulate returns getWebServiceStatus method.
		$stubSobekIntegrator->method('getWebServiceStatus')->willReturn($this->builderSobekIntegrator->getFakeWebServiceStatus());

		$this->assertFalse($stubSobekIntegrator->serviceIsOnline());
	}

	public function testGetStatusSobekWebServiceMustBeAnArray() {
		$this->assertInternalType('array', $this->sobekIntegrator->getWebServiceStatus(),
			"URL Sobek web service did not return information in an array.");
	}

	public function testGetSobekParametersMustBeAnArray() {

		$sobekParams = $this->sobekIntegrator->readConfig();

		$this->assertInternalType('array', $sobekParams,
			"JSON Sobek parameters were not converted correctly");

		return $sobekParams;
	}

	/**
	 * @depends testGetSobekParametersMustBeAnArray
	 */
	public function testReturnSetupInputParams(array $sobekParams) {

		// Check exists inputs config in parameters.
		$this->assertArrayHasKey('input', $sobekParams);
		$this->assertInternalType('array', $sobekParams['input']);

		$configInput = $this->sobekIntegrator->setupInputParams($sobekParams['input']);
		$this->assertInternalType('string', $configInput);

		return $configInput;
	}

	/**
	 * @depends testGetSobekParametersMustBeAnArray
	 */
	public function testReturnSetupOutputParams(array $sobekParams) {

		// Check exists output config in parameters.
		$this->assertArrayHasKey('output', $sobekParams);
		$this->assertInternalType('array', $sobekParams['output']);

		$configOutput = $this->sobekIntegrator->setupOutputParams($sobekParams['output']);
		$this->assertInternalType('string', $configOutput);

		return $configOutput;
	}

	public function testConfigParamsToSendSobek() {

		$sobekParams = $this->sobekIntegrator->configParams('textContext');

		$this->assertInternalType('array', $sobekParams);
		$this->assertArrayHasKey('entrada', $sobekParams);

		return $sobekParams;
	}

	/**
	 * @depends testConfigParamsToSendSobek
	 */
	public function testSendTextToSobekAndReturnSuccessfullyXml($sobekParams) {

		// Creat stub Sobek integrator.
		$stubSobekIntegrator = $this->getMockBuilder('ARFinder\Sobek\Integrator')->setMethods(array('getConfigs'))->getMock();

		// Manipulate getConfigs method with successfuly returns.
		$fakeConfig = new stdClass();
		$fakeConfig->urlSobekWebService = 'file:///c:/wamp64/www/project-tcc/tests/Builders/fake_sobek_return_xml.xml';
 
		$stubSobekIntegrator->method('getConfigs')->willReturn($fakeConfig);

		$returnSobek = $stubSobekIntegrator->sendToSobek($sobekParams);

		$this->assertInternalType('string', $returnSobek);
	}

	/**
	 * @depends testConfigParamsToSendSobek
	 * @expectedException              ARFinder\Exceptions\SobekBadXMLReturnException
	 * @expectedExceptionMessage 	XML devolvido pelo serviço do Sobek não é válido
	 */
	public function testSendTextToSobekAndReturnUxpectedXmlThrowsSobekBadXmlReturnException($sobekParams) {

		// Creat stub Sobek integrator.
		$stubSobekIntegrator = $this->getMockBuilder('ARFinder\Sobek\Integrator')->setMethods(array('getUrlSobekWebService'))->getMock();

		// Manipulate getUrlSobekWebService method with fail returns.
		$stubSobekIntegrator->method('getUrlSobekWebService')->willReturn('http://project-tcc.local/tests/Builders/fake_sobek_return_not_xml.xml');

		// Should throws exception.
		$stubSobekIntegrator->sendToSobek($sobekParams);
	}

	/**
	 * @depends testSendTextToSobekAndReturnSuccessfullyXml
	 */
	public function testGetGraphUseRigthXmlReturnMustBeReturnSimpleXml() {
		// Creat stub Sobek integrator.
		$stubSobekIntegrator = $this->getMockBuilder('ARFinder\Sobek\Integrator')->setMethods(array('configParams', 'getUrlSobekWebService'))->getMock();

		// Manipulate configParams method.
		$stubSobekIntegrator->method('configParams')->willReturn('-c 3 -m 3 -o 1 -l 1 -x -t textContext');

		// Manipulate getUrlSobekWebService method with fail returns.
		$stubSobekIntegrator->method('getUrlSobekWebService')->willReturn('http://project-tcc.local/tests/Builders/fake_sobek_return_xml.xml');

		// Bad XML should return false.
		$this->assertInstanceOf('SimpleXMLElement', $stubSobekIntegrator->getGraph('textContext'));

	}

	/**
	 * @depends testSendTextToSobekAndReturnSuccessfullyXml
	 */
	public function testGetGraphUseBadXmlReturnMustBeReturnFalse() {
		// Creat stub Sobek integrator.
		$stubSobekIntegrator = $this->getMockBuilder('ARFinder\Sobek\Integrator')->setMethods(array('configParams', 'getUrlSobekWebService'))->getMock();

		// Manipulate configParams method.
		$stubSobekIntegrator->method('configParams')->willReturn('-c 3 -m 3 -o 1 -l 1 -x -t textContext');

		// Manipulate getUrlSobekWebService method with fail returns.
		$stubSobekIntegrator->method('getUrlSobekWebService')->willReturn('http://project-tcc.local/tests/Builders/fake_sobek_return_not_xml.xml');

		// Bad XML should return false.
		$this->assertFalse($stubSobekIntegrator->getGraph('textContext'));
	}

}

?>
