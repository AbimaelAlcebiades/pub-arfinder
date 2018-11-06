<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\App;

/**
 * Text Analyzer agent.
 */
class AgentTextAnalyzer {

	/**
	 * @var string Text to Sobek analyze.
	 */
	private $text;

	public function getText()
	{
		// ####################################
		$this->text = 'Devo pegar o texto do editor';
	}

	public function setText()
	{

	}

	public function sendTextToSobek()
	{
		// ################################
		return array('teste' => 2);
	}



}

?>
