<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Controller;

use ARFinder\App\RestFullApi;
use \Exception;

/**
 * Class for router ajax requisitions.
 *
 * @since  1.0
 */
class RouterAjaxController {

	/**
	 * @var Restufull api.
	 */
	private $restfullApi;

	/**
	 * Constructor class.
	 */
	function __construct($request) {

		// Instantiate restfull api with data from request.
		$this->restfullApi = new RestFullApi($request);

		// Execute request.
		// $this->executeRequest();
	}

	/**
	 * Execute controller.
	 *
	 * @return void
	 */
	public function execute() {

		$this->restfullApi->executeRequest();

		// try {
		// 	$controller = $this->getVariableFromRequest('controller');
		// 	$method = $this->getVariableFromRequest('method');
		// 	$parameters = $this->getParameters();
		// } catch (Exception $e) {
		// 	var_dump($e->getMessage());
		// }
		// // var_dump($controller);
		// // var_dump($method);
		// // var_dump($parameters);

		// $controllerClass = __NAMESPACE__ . '\\' . ucfirst($controller) . 'Controller';
		// $controller = new $controllerClass();

		// var_dump($parameters);

		// $controller->$method($parameters);
	}

	public function getVariableFromRequest($variableName) {
		if (isset($_REQUEST[$variableName])) {
			return $_REQUEST[$variableName];
		} else {
			throw new Exception("Não foi possível localizar a variável $variableName na requisição");
		}
	}

	public function getParameters() {

		// Parameters string that be returned.
		$stringParameters = '';

		// Parameters values.
		$parameters = array();

		// Through parameters.
		foreach ($_REQUEST as $key => $value) {
			// Check if key is substring 'param'.
			if (strpos($key, 'param') !== false) {
				$parameters[$key] = $value;
			}
		}

		// Check if parameters is not empty.
		if (!empty($parameters)) {
			// Sort array by key.
			ksort($parameters);
		}

		return $stringParameters;
	}

}

?>
