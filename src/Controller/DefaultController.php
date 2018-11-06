<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Controller;

use \Exception;

/**
 * Default controller.
 */
abstract class DefaultController {

	/**
	 * Execute controller.
	 * 
	 * @return void
	 */
	public function executeFromApi() {

		$request = array_merge($_GET, $_POST);
		$requestMethod = "{$request['task']}ApiRequest";
		// Checks if task is an class method existing.
		if(method_exists($this, $requestMethod)){
			$this->$requestMethod();
		}else{
			throw new Exception("O SRFinder não pode processa a task {$request['task']}", 404);
		}
	}

}

?>
