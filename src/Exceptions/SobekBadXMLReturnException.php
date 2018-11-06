<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Exceptions;

use Exception;

/**
 * Exception receive wrong XML from Sobek web sevice.
 */
class SobekBadXMLReturnException extends Exception {

	// Constructor.
	public function __construct($message, $code = 0, Exception $previous = null) {

		// Call parent constructor.
		parent::__construct($message, $code, $previous);
	}

	/**
	 * Send notification tells there is something wrong with XML returns Sobek websevice.
	 * @return void
	 */
	public function sendNotification() {
		// Empty... in construct. ##########################
		var_dump("Enviou uma notificação.");
	}
}

?>
