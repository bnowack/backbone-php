<?php

namespace spec\BackbonePhp;

use PhpSpec\ObjectBehavior;

class ConfigSpec extends ObjectBehavior
{

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
    
}
