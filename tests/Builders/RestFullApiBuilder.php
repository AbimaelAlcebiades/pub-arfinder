<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Builders;

use ARFinder\App\RestFullApi;

/**
 * Rest full api test data builder.
 */
class RestFullApiBuilder {

	/**
	 * @var array Request for api.
	 */
	private $request = array();

	/**
	 * Configure request state.
	 *
	 * @param boolean $hasRequest True if exists request, false if not request.
	 *
	 * @return void.
	 */
	public function existsRequest($hasRequest){
		// Set request state according parameter.
		$this->request = ($hasRequest) ? array() : null  ;
	}

	/**
	 * Set variable in request.
	 * @param string $name Variable name.
	 * @param mixed $value Variable values;
	 * @return void.
	 */
	public function setVariableRequest(string $name, $value)
	{
		// Add values to request.
		$this->request[$name] = $value;
	}

	/**
	 * Create instance of Restfull api.
	 * @return RestFullApi Returns object created.
	 */
	public function create()
	{
		// Create restfull api object.
		return new RestFullApi($this->request);
	}

}

?>
