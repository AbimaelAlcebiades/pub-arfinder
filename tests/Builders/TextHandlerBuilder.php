<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Builders;

use ARFinder\App\TextHandler;
use SimpleXMLElement;

/**
 * TextHandler test data builder.
 */
class TextHandlerBuilder {

	/**
	 * @var TextHandler Configurable object TextHandler.
	 */
	public $textHandler;

	/**
	 * Classe constructor.
	 */
	function __construct() {
		// Create new instance TextHandler.
		$this->textHandler = new TextHandler();
	}

	/**
	 * Get simulated return SobekXML.
	 * @return SimpleXMLElement Returns fake XML Sobek.
	 */
	public function getFakeXMLSobek() {

		// Returns fake XML Sobek.
		return new SimpleXMLElement(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'fake_sobek_return_xml.xml'));
	}

	/**
	 * Create an TextHandler object.
	 * @return TextHandler Return an configured TextHandler object.
	 */
	public function create() {
		return $this->textHandler;
	}
}

?>
