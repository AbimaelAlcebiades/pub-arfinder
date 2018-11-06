<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Builders;

use ARFinder\App\AgentTextAnalyzer;

/**
 * Agent Text Analyzer test data builder.
 */
class AgentTextAnalyzerBuilder {

	/**
	 * @var AgentTextAnalyzer Configurable object Agent Text Analyser.
	 */
	public $agentTextAnalyzer;

	/**
	 * Classe constructor.
	 * @return void;
	 */
	function __construct() {
		// Create new instance Agent Text Analyser.
		$this->agentTextAnalyzer = new AgentTextAnalyzer();
	}

	/**
	 * Get simulated user text.
	 * @return string Returns fake user text for agent use.
	 */
	public function getFakeUserText() {

		// Returns text file simulating user text.
		return file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "fake_user_text.txt");
	}

	/**
	 * Create an AgentTextAnalyzer object.
	 * @return AgentTextAnalyzer Return an configured Agent Text Analyzer object.
	 */
	public function create() {
		return $this->agentTextAnalyzer;
	}
}

?>
