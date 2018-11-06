<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

// Start session.
session_start();

// Load application paths.
require_once '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'application_paths.php';

// Load the Composer autoloader
require ROOT_SITE_PATH . '/vendor/autoload.php';

// Instantiate the application.
$application = new ARFinder\App\Application();