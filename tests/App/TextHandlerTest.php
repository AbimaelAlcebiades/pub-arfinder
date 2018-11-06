<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder;

use ARFinder\Builders\TextHandlerBuilder;
use ARFinder\Test\TestCase;

class TextHandlerTest extends TestCase {

	/**
	 * @var Instance TextHandler.
	 */
	private $textHandler;

	/**
	 * @var Instance data builder TextHandler.
	 */
	private $builderTextHandler;

	/**
	 * Setup test environment.
	 */
	public function setUp() {
		// Instantiate data builder TextHandler.
		$this->builderTextHandler = new TextHandlerBuilder();
		// Create an TextHandler to scenario.
		$this->textHandler = $this->builderTextHandler->create();
		// Call parent method.
		parent::setUp();
	}

	public function testReceiveXMLFromTextAnalyzerAgentAndReturnListOfTerms() {
		// Creat stub TextAnalyzerAgent.
		$stubTextAnalyzerAgent = $this->getMockBuilder('ARFinder\App\TextAnalyzerAgent')->setMethods(array('toDeliverXMLSobek'))->getMock();

		// Manipulate returns toDeliverXMLSobek method.
		$stubTextAnalyzerAgent->method('toDeliverXMLSobek')->willReturn($this->builderTextHandler->getFakeXMLSobek());

		$return = $this->textHandler->handleXMLSobek($stubTextAnalyzerAgent->toDeliverXMLSobek());

		$this->assertInternalType('array', $return);

	}
}

?>
