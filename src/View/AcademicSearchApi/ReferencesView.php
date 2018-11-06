<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\View\AcademicSearchApi;

/**
 * References view class.
 */
class ReferencesView {
	/**
	 * Display an template.
	 *
	 * @param string $templateName Template name to render.
	 *
	 * @return void
	 */
	public function displayTemplate($templateName) {

		// Require template archive.
		require TEMPLATES_PATH . DIRECTORY_SEPARATOR . $this->getClassName() . DIRECTORY_SEPARATOR . $templateName . '.php';
	}

	/**
	 * Get object class name.
	 *
	 * @param boolean $ignoreNameSpace Flag to ignore class name space.
	 *
	 * @return string Return class name.
	 */
	public function getClassName($ignoreNameSpace = true) {
		// Get class name.
		$className = ($ignoreNameSpace) ? (new \ReflectionClass($this))->getShortName() : __CLASS__;

        // Handle class name.
        return str_replace('View', '', $this->getClassName());

        return $className;
	}

}

?>
