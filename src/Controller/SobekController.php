<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Controller;

/**
 * Sobek controller class.
 */
class SobekController {

	/**
	 * Call an view.
	 * 
	 * @param string $viewName View name that be call.
	 * @param array $methods Method and params to execute, array key must be method name and
	 * values must be parameters of method.
	 * @param string $format View format to call.
	 *
	 *  @return void
	 */
	public function callView($viewName, $methods, $format = 'html') {

		// Create view name based in receive parameters.
		$viewClassName = 'ARFinder\\View\\' . ucfirst($viewName) . '\\' . ucfirst($viewName) . ucfirst($format) . 'View';

		// Instantiate an view.
		$view = new $viewClassName();

		// Through by methods.
		foreach ($methods as $method => $parameters) {
			// Configure parameters.
			$parameters = implode($parameters, ',');
			// Call method with your parameters.
			$view->$method($parameters);
		}
	}
}

?>
