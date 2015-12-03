<?php

namespace spec\BackbonePhp;

use PhpSpec\ObjectBehavior;

class ConfigSpec extends ObjectBehavior
{

    protected static function fixturesPath() {
        return __DIR__ . '/../../fixtures/';
    }
    
    public function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Config');
    }
    
    public function it_sets_and_gets_an_option()
    {
        $this->set('foo', 'bar')->shouldReturn($this);
        $this->get('foo')->shouldReturn('bar');
        $this->get('baz')->shouldReturn(null);
    }
    
    public function it_loads_options_from_json()
    {
        $this->load(self::fixturesPath() . 'config-1.json')->shouldReturn($this);
        $this->get('foo')->shouldReturn('bar');
        $this->get('baz')->shouldReturn(null);
        $this->get('permissions')->editEverything->shouldHaveType('\stdClass');
    }
    
    public function it_loads_options_as_object()
    {
        $this->load(self::fixturesPath() . 'config-1.json')->shouldReturn($this);
        $this->get('object')->shouldHaveType('\stdClass');
        $this->get('object')->foo->shouldReturn('bar');
    }
    
    public function it_combines_loaded_config_options()
    {
        $this->load(self::fixturesPath() . 'config-1.json', array('permissions'))->shouldReturn($this);
        $this->load(self::fixturesPath() . 'config-2.json', array('permissions'))->shouldReturn($this);
        $this->get('foo')->shouldReturn('baz');
        $this->get('baz')->shouldReturn(null);
        $this->get('bat')->shouldReturn('test');
        $this->get('permissions')->shouldHaveType('\stdClass');
        $this->get('permissions')->editEverything->shouldHaveType('\stdClass');
        $this->get('permissions')->readAllPosts->shouldHaveType('\stdClass');
    }
    
    public function it_returns_a_default_value()
    {
        $this->get('undefined', 'test')->shouldReturn('test');
    }
    
}
