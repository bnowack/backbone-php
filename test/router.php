<?php

/**
 * Sample router script for PHP's command-line server.
 * 
 * This router is for testing sites and applications using BackbonePHP with Behat.
 */

// don't allow access to the router script during production
if (php_sapi_name() !== 'cli-server') {
    die('The router script is only available during development');
}

// Ensure time() is E_STRICT-compliant
date_default_timezone_set(@date_default_timezone_get());

// Define path constants
define("BACKBONEPHP_DIR",       dirname(__DIR__) . '/');  // repo dir is 1 hop up from "/test/router.php"
define("BACKBONEPHP_APP_DIR",   BACKBONEPHP_DIR);     // same as repo dir during development

// Include autoloader
require_once BACKBONEPHP_APP_DIR . 'vendor/autoload.php';

// Serve static assets
if (preg_match('/\.(png|jpg|jpe?g|gif|ico|css|js|json|txt)($|\?)/i', $_SERVER["REQUEST_URI"]) && file_exists($_SERVER["REQUEST_URI"])) {
    return false;
}
// Serve dynamic contents
else {
    (new BackbonePhp\Application\Application())
        // load default config
        ->loadConfig(BACKBONEPHP_DIR . 'src/BackbonePhp/Application/config/permissions.json')
        ->loadConfig(BACKBONEPHP_DIR . 'src/BackbonePhp/Application/config/groups.json')
        ->loadConfig(BACKBONEPHP_DIR . 'src/BackbonePhp/Application/config/models.json')
        ->loadConfig(BACKBONEPHP_DIR . 'src/BackbonePhp/Application/config/application.json')
        // load test config
        ->loadConfig(BACKBONEPHP_DIR . 'test/fixtures/dev-config.json')
        // process request
        ->dispatchRequest()
        ->getResponse()
            ->sendHeaders()
            ->sendBody()
    ;
}
