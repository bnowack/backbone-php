<?php

namespace spec;

use BackbonePhp\Config\Config;

/**
 * Base Spec class with re-usable methods
 */
class Spec
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
        $config->load(Spec::rootPath() . 'src/BackbonePhp/Application/config/permissions.json');
        $config->load(Spec::rootPath() . 'src/BackbonePhp/Application/config/groups.json');
        $config->load(Spec::rootPath() . 'src/BackbonePhp/Application/config/models.json');
        $config->load(Spec::rootPath() . 'src/BackbonePhp/Application/config/application.json');
        $config->load(Spec::fixturesPath() . 'dev-config.json');
        return $config;
    }
    
}
