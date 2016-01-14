<?php

// Ensure time() is E_STRICT-compliant (optional, if specified in php.ini)
if (function_exists('date_default_timezone_get')) {
	date_default_timezone_set(@date_default_timezone_get());
}

// Define path constants
define("BACKBONEPHP_DIR",       dirname(dirname(__DIR__)) . '/');   // repo dir is 2 hops up from "/test/spec/bootstrap.php"
define("BACKBONEPHP_APP_DIR",   BACKBONEPHP_DIR);                   // same as repo dir during development

// load PHPSpec utils
include_once(BACKBONEPHP_DIR . 'test/spec/Spec.php');
