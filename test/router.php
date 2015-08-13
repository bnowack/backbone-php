<?php

// don't allow access to the router script during production
if (php_sapi_name() !== 'cli-server') {
    throw new Exception('The router script is only available during development');
}

// the base directory is 2 hops up from /test/router.php
require_once dirname(__DIR__) . '/vendor/autoload.php';
