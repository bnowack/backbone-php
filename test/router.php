<?php

/**
 * Sample router script for PHP's command-line server.
 * 
 * This router is for testing sites and applications using BackbonePHP with Behat.
 * 
 */

// don't allow access to the router script during production
if (php_sapi_name() !== 'cli-server') {
    die('The router script is only available on the test server');
}

// Ensure time() is E_STRICT-compliant (optional, if specified in php.ini)
if (function_exists('date_default_timezone_get')) {
	date_default_timezone_set(@date_default_timezone_get());
}
// the base directory is 2 hops up from /test/router.php
require_once dirname(__DIR__) . '/vendor/autoload.php';

// serve static assets
if (preg_match('/\.(png|jpg|jpe?g|gif|css|js|json|txt)$/i', $_SERVER["REQUEST_URI"])) {
    return false;
} else {
    (new BackbonePhp\Application())
        ->setConfig('fileBase', dirname(__DIR__) . '/')
        ->loadConfig('src/config/default-models.json')
        ->loadConfig('test/fixtures/router-config.json')
        ->dispatchRequest()
        ->getResponse()
            ->sendHeaders()
            ->sendBody()
    ;
}
