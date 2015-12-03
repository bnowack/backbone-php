<?php

namespace spec\BackbonePhp;

use PhpSpec\ObjectBehavior;

class RequestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Request');
    }
    
    function it_sets_a_path()
    {
        $this->set('path', '/test')->get('path')->shouldReturn('/test');
        $this->shouldThrow('BackbonePhp\Exception\UndefinedPropertyException')->duringSet('does-not-exist');
    }
    
    function it_sets_only_known_properties()
    {
        $this->shouldThrow('BackbonePhp\Exception\UndefinedPropertyException')->duringSet('does-not-exist');
    }
    
}
