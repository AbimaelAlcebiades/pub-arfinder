<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\App;

use ARFinder\App\CacheSystem;
use ARFinder\App\RestFullApi;
use ARFinder\Controller\RouterAjaxController;
use Exception;

/**
 * Class application, where everything begins.
 */
class Application {

  /**
	 * Controller that be executed from application.
	 * 
   * @var DefaultController 
   */
	protected $controller;

  /**
	 * Rest full api instance to execute requestions.
	 * 
   * @var RestFullApi 
   */
	protected $restFullApi;

	/**
	 * Constructor class.
	 */
	function __construct() {
    // Performs tasks to handle request.
		$this->executeRequest();
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
   * Get Rest Full Appi instance.
   *
   * @return RestFullApi Return instance of rest full api.
   */
  public function getRestFullApi() {
      return (empty($this->restFullApi)) ? new RestFullApi() : $this->restFullApi;
  }

  /**
   * Set rest full api.
   *
   * @param RestFullApi $restFullApi Instance RestFullApi to set in application.
   */
  public function setRestFullApi(RestFullApi $restFullApi) {
      $this->restFullApi = $restFullApi;
  }

	/**
	 * Execute data from request calling controller and method matching.
	 *
	 * @return void.
	 */
	public function executeRequest() {
		// Checks value param api in GET request.
		if(isset($_GET['execute']) && ($_GET['execute'] == 'arfinder_api')) {
		  // Execute api.
      $api = $this->getRestFullApi();
      $api->executeRequest();
		}

		// // Check if exists variable "execute".
		// if (isset($_GET['execute']) || isset($_POST['execute']) ) {

    //     // TODO: ESTA PARTE DO CÓDIGO NÃO ESTÁ COBERTA POR TESTES. NÃO SEI COMO FAZÊ-LO.
				
		// 		// Performs execute request.
		// 		switch ($_REQUEST['execute']) {
  	// 			// Execute api.
  	// 			case 'api':
    //         // Execute api.
    //         $api = $this->getRestFullApi();
    //         $api->executeRequest();
    // 				break;

    //       // ############# EU ESTOU USANDO ISSO??????????????
  	// 			// case 'ajax':
  	// 			// 	// Set controller ajax.
  	// 			// 	$this->controller = new RouterAjaxController($request);
  	// 			// 	//$this->controller->load('RouterAjaxController');
  	// 			// 	// Execute controller.
  	// 			// 	$this->controller->execute();
  	// 			// 	break;

    //       // // Invalid execute option
  	// 			// default:
    //       //   // Execute option not find.
    //       //   throw new Exception('O método '.__FUNCTION__. ' não permite o valor
    //       //   '.$_REQUEST['execute'].' para o parâmeto execute', 500);
  	// 			// 	break;
	  //     }
		// 	} else {
    //     // // Param execute not find.
    //   	// throw new Exception("O método " . __FUNCTION__ . " não pode ser processado pois não foi encotrado parâmetro obrigatório execute.", 500);
		// 	}
		// } else {
    //         // // $_REQUEST is empty.
    //         // throw new Exception('Não existem dados na requisição para processamento do método ' . __FUNCTION__, 500);
    //     }
	}
}
?>
