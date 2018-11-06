<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\View\Sobek;

use ARFinder\Sobek\Integrator;

/**
 * Sobek html view class.
 */
class SobekHtmlView {

	/**
	 * @var ARFinder\SobekIntregrator Integrator with Sobek system.
	 */
	private $sobekIntegrator;

	// Constructor.
	function __construct() {
		// Initiate sobek integrator.
		$this->sobekIntegrator = new Integrator();
	}

	/**
	 * Display an template.
	 * @param string $templateName Template name to render.
	 * @return void
	 */
	public function displayTemplate($templateName) {

		// Require template archive.
		require TEMPLATES_PATH . DIRECTORY_SEPARATOR . strtolower($this->getMvcObject()) . DIRECTORY_SEPARATOR . $templateName . '.php';
	}

	/**
	 * Get object class name.
	 * @param boolean $ignoreNameSpace Flag to ignore class name space.
	 * @return string Return class name.
	 */
	public function getClassName($ignoreNameSpace = true) {

		// Get class name.
		return ($ignoreNameSpace) ? (new \ReflectionClass($this))->getShortName() : __CLASS__;

	}

	/**
	 * Get name object that is reference view.
	 * @param type|string $value
	 * @return type
	 */
	public function getMvcObject() {
		// Handle class name.
		return str_replace('HtmlView', '', $this->getClassName());
	}
}

?>
