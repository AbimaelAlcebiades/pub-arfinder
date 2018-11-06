<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\App;

use \Exception;

/**
 * Restfull api class.
 */
class RestFullApi {

	/**
	 * Execute data from request.
	 */
	public function executeRequest() {

		try {
			// Checks mandatory data.
			$this->checkMinimumDataToExecute();

			// Get controller from request.
			$controller = $this->getController($_GET['controller'] ?? $_POST['controller']);

			// Execute controller.
			$controller->executeFromApi();

      		exit("terminou a execução da RestFullApi");

		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}

	/**
	 * Check minimum data to execute API.
	 *
	 * @return void
	 *
	 * @throws Exception If any mandatory variable not found.
	 */
	public function checkMinimumDataToExecute() {
		// Check variable controller.
		if (!$this->checkVariableInRequest('controller')) {
			throw new Exception('Variável controller não encontrada na requisição');
		}

	}

	/**
	 * Check varible in properties request.
	 *
	 * @param string $name Variable name to search.
	 *
	 * @return boolean Returns true if variable exists, otherwise returns false.
	 */
	public function checkVariableInRequest($name) {
		return array_key_exists($name, array_merge($_GET, $_POST));
	}

	/**
	 * Get controller.
	 *
	 * @param string $name Controller name.
	 *
	 * @return Object Returns controller.
	 *
	 * @throws Exception If controller don't exists.
	 */
	public function getController($name) {

		// Build controller class.
		$controllerClass = 'ARFinder\\Controller\\' . ucfirst($name) . 'Controller';

		// Checks if class exists.
		if (class_exists($controllerClass)) {
			return new $controllerClass();
		} else {
			throw new Exception("Classe $controllerClass não encontrada");
		}

	}
}

?>
