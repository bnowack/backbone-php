<?php

namespace spec;

/**
 * Base Spec class with re-usable methods
 */
class Spec
{

    public static function rootPath()
    {
        return dirname(dirname(__DIR__)) . '/';
    }
    
    public static function testsPath()
    {
        return dirname(__DIR__) . '/';
    }
    
    public static function fixturesPath()
    {
        return dirname(__DIR__) . '/fixtures/';
    }
    
}
