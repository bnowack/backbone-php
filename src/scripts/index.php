<?php

// Ensure time() is E_STRICT-compliant
date_default_timezone_set(@date_default_timezone_get());

// file system base directory, derived from `/vendor/bnowack/backbone-php/src/scripts/index.php`
$fileBase = dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/';

// include `vendor/autoload.php`
require_once $fileBase . 'vendor/autoload.php';

// create and start the application
(new BackbonePhp\Application())
    ->setConfig('fileBase', $fileBase)
    ->loadConfig('vendor/bnowack/backbone-php/src/config/default-models.json')
    ->dispatchRequest()
    ->getResponse()
        ->sendHeaders()
        ->sendBody()
;
