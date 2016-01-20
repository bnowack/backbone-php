<?php

// Ensure time() is E_STRICT-compliant
date_default_timezone_set(@date_default_timezone_get());

// Define path constants
define("BACKBONEPHP_DIR",       dirname(dirname(__DIR__)) . '/');                             // repo dir is 2 hops up from `/vendor/bnowack/backbone-php/src/scripts/index.php`
define("BACKBONEPHP_APP_DIR",   dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/');  // 5 hops up

// Include autoloader
require_once BACKBONEPHP_APP_DIR . 'vendor/autoload.php';

// Create and start the application
(new BackbonePhp\Application\Application())
    // load default config
    ->loadConfig(BACKBONEPHP_DIR . 'src/BackbonePhp/Application/config/permissions.json')
    ->loadConfig(BACKBONEPHP_DIR . 'src/BackbonePhp/Application/config/groups.json')
    ->loadConfig(BACKBONEPHP_DIR . 'src/BackbonePhp/Application/config/models.json')
    ->loadConfig(BACKBONEPHP_DIR . 'src/BackbonePhp/Application/config/application.json')
    // load app config
    ->loadConfig(BACKBONEPHP_APP_DIR . 'config/permissions.json', true)
    ->loadConfig(BACKBONEPHP_APP_DIR . 'config/groups.json', true)
    ->loadConfig(BACKBONEPHP_APP_DIR . 'config/models.json', true)
    ->loadConfig(BACKBONEPHP_APP_DIR . 'config/nodes.json', true)
    ->loadConfig(BACKBONEPHP_APP_DIR . 'config/server.json', true)
    ->loadConfig(BACKBONEPHP_APP_DIR . 'config/application.json', true)
    // process the request
    ->dispatchRequest()
    ->getResponse()
        ->sendHeaders()
        ->sendBody()
;
