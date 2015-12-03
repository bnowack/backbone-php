<?php

namespace spec\BackbonePhp;

use PhpSpec\ObjectBehavior;

use BackbonePhp\Config;
use BackbonePhp\Request;
use BackbonePhp\Response;

class RouterSpec extends ObjectBehavior
{

    protected static function testsPath() {
        return dirname(dirname(__DIR__)) . '/';
    }
    
    protected static function fixturesPath() {
        return dirname(dirname(__DIR__)) . '/fixtures/';
    }
    
    public function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Router');
    }
    
    public function it_has_a_config_object() {
        $this->config->shouldHaveType('BackbonePhp\Config');
    }
    
    public function it_dispatches_a_request()
    {
        $config = new Config();
        $config->load(self::fixturesPath() . 'router-config.json');
        $request = new Request($config);
        $response = new Response($config);
        $this->dispatchRequest($request, $response)->shouldReturn($this);
    }
    
}
