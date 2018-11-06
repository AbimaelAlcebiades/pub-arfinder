<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Builders;

use ARFinder\App\Application;

/**
 * Application test data builder.
 */
class ApplicationBuilder {
	/**
	 * Get application.
	 *
	 * @return Application Return an Application.
	 */
	public function getApplication() {
		return new Application();
	}

    /**
     * Populate $_REQUEST variable.
     *
     * @param $variables Variables to popualate array $_REQUEST, values must be enter values in pairs.
     *
     * @return void Set data to $_REQUEST variable.
     */
    public function populateRequest(array $variables = array()) {

        if(empty($variables)){
            $_REQUEST['anyKey'] = 'any value';
        }else{
            foreach ($variables as $paramName => $paramValue) {
                $_REQUEST[$paramName] = $paramValue;
            }
        }
    }
}

?>
