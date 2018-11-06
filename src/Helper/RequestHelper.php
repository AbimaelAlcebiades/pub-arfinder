<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Helper;

/**
 * Class string helper.
 */
class RequestHelper
{

    /**
	 * Check variable in request.
	 *
	 * @param string    $name   Variable name to search in request.
     * @param array     $from   List sources where search variable, default is GET and POST.
	 *
	 * @return boolean Returns value if variable exists, otherwise returns false.
	 */
	public static function getVariable($name, array $from = array('GET', 'POST') ) {

        $sources = array();

        foreach ($from as $value) {
            switch ($value) {
                case 'GET':
                    $sources = array_merge($sources, $_GET);
                    break;

                case 'POST':
                    $sources = array_merge($sources, $_POST);
                    break;
    
                default:
                    break;
            }
        }
       
        if(array_key_exists($name, $sources)){
            return $sources[$name];
        }
       
        return false;
	}
}
