<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Builders;

use ARFinder\Sobek\Integrator;

/**
 * Sobek integrator test data builder.
 */
class SobekIntegratorBuilder {

	/**
	 * @var SobekIntegrator Configurable object Sobek integrator.
	 */
	public $sobekIntegrator;

	/**
	 * @var boolean Flag status Sobek web service.
	 */
	private $statusWebService = true;

	/**
	 * Classe constructor.
	 * @return void;
	 */
	function __construct() {

		// Create new instance Sobek integrator.
		$this->sobekIntegrator = new Integrator();
	}

	/**
	 * Sets Sobek web service online.
	 * @return void.
	 */
	public function webServiceIsOnline() {
		$this->statusWebService = true;
	}

	/**
	 * Sets Sobek web service offline.
	 * @return void.
	 */
	public function webServiceIsOffline() {
		$this->statusWebService = false;
	}

	/**
	 * Get simulated Sobek web service status.
	 * @return array Returns fake Sobek web service data.
	 */
	public function getFakeWebServiceStatus() {

		// Check Sobek webserive status object.
		if ($this->statusWebService) {
			// Returns online fake data.
			return json_decode(
				file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "fake_service_online.json"),
				true);
		}

		// Returns offline fake data.
		return json_decode(
			file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "fake_service_offline.json"),
			true);
	}

	/**
	 * Create an Sobek integrator object.
	 * @return SobekIntegrator Return an configured Sobek integrator object.
	 */
	public function create() {
		return $this->sobekIntegrator;
	}
}

?>
