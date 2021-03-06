<?php

use BackbonePhp\Config\Config;

/**
 * PHPSpec helper class with re-usable methods
 */
class SpecHelper
{

    public static function rootPath()
    {
        return BACKBONEPHP_DIR;
    }
    
    public static function testsPath()
    {
        return BACKBONEPHP_DIR . 'test/';
    }
    
    public static function fixturesPath()
    {
        return BACKBONEPHP_DIR . 'test/fixtures/';
    }
    
    public static function getDevConfig()
    {
        $config = new Config();
        $config->load(self::rootPath() . 'src/BackbonePhp/Application/config/permissions.json');
        $config->load(self::rootPath() . 'src/BackbonePhp/Application/config/groups.json');
        $config->load(self::rootPath() . 'src/BackbonePhp/Application/config/models.json');
        $config->load(self::rootPath() . 'src/BackbonePhp/Application/config/application.json');
        $config->load(self::fixturesPath() . 'dev-config.json');
        return $config;
    }
    
}
