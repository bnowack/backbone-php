<?php

// Ensure time() is E_STRICT-compliant (optional, if specified in php.ini)
if (function_exists('date_default_timezone_get')) {
	date_default_timezone_set(@date_default_timezone_get());
}

// load PHPSpec utils
include_once(__DIR__ . '/Spec.php');
