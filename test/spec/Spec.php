<?php

namespace spec;

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
    }
    
}
