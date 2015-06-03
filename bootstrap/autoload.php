<?php

/**
 * Include packages
 */
require(__DIR__ . '/../vendor/autoload.php');

/**
 * Instantiate the app
 */
$app = new Http\App();

/**
 * Load the routes
 */
require_once(__DIR__ . '/../Http/routes.php');
