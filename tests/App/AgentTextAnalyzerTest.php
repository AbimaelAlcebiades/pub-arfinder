<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder;

use ARFinder\Builders\AgentTextAnalyzerBuilder;
use ARFinder\Test\TestCase;
use ARFinder\App\AgentTextAnalyzer;

class AgentTextAnalyzerTest extends TestCase {

	/**
	 * @var Instance Agent Text Analyzer.
	 */
	private $agentTextAnalyzer;

	/**
	 * @var Instance Data builder Agent Text Analyser.
	 */
	private $builderAgentTextAnalyzer;

	/**
	 * @var Instance Mock Agent Text Analyser.
	 */
	private $mockAgentTextAnalyzer;

	/**
	 * Setup test environment.
	 */
	public function setUp() {
		// Instantiate data builder Agent Text Analyser.
		$this->builderAgentTextAnalyzer = new AgentTextAnalyzerBuilder();
		// Create an Agent Text Analyser.
		$this->agentTextAnalyzer = $this->builderAgentTextAnalyzer->create();

		$this->mockAgentTextAnalyzer = $this->getMockBuilder('ARFinder\App\TextAnalyser');
		// Call parent method.
		parent::setUp();
	}

	public function testWhenAgentCallMethodGetTextAttributeTextMustBePopulated()
	{
	 	$this->agentTextAnalyzer->getText();
	 	$this->assertAttributeNotEmpty('text', $this->agentTextAnalyzer);
	}

	############### EM CONSTRUÇÃO
	public function testAgentSendTextToSobekAndReceiveXml()
	{
		// Creat stub Agent integrator.
		$stubAgentTextAnalyser = $this->mockAgentTextAnalyzer->setMethods(array('getText'))->getMock();

		// Manipulate returns getText method.
		$stubAgentTextAnalyser->method('getText')->willReturn($this->builderAgentTextAnalyzer->getFakeUserText());

		$this->agentTextAnalyzer->getText();

		$listOfTerms = $this->agentTextAnalyzer->sendTextToSobek();

		$this->assertInternalType('array', $listOfTerms);
		$this->assertNotEmpty($listOfTerms);


	}

	############### EM CONSTRUÇÃO
	public function testAgentSendTextToTextHandleAndReceiveListOfTerms()
	{
		// Creat stub Agent integrator.
		$stubAgentTextAnalyser = $this->mockAgentTextAnalyzer->setMethods(array('getText'))->getMock();

		// Manipulate returns getText method.
		$stubAgentTextAnalyser->method('getText')->willReturn($this->builderAgentTextAnalyzer->getFakeUserText());

		$this->agentTextAnalyzer->getText();
	}
}

?>
