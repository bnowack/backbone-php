<?php

// Ensure time() is E_STRICT-compliant
date_default_timezone_set(@date_default_timezone_get());

// Define path constants
define("BACKBONEPHP_DIR",       dirname(dirname(__DIR__)) . '/');   // repo dir is 2 hops up from "/test/phpspec/bootstrap.php"
define("BACKBONEPHP_APP_DIR",   BACKBONEPHP_DIR);                   // same as repo dir during development

// load phpspec helper
include_once(BACKBONEPHP_DIR . 'test/phpspec/SpecHelper.php');
