<?php

namespace spec\BackbonePhp;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApplicationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Application');
    }
    
    public function it_should_set_and_get_a_config_option()
    {
        $this->setConfig('test', 'Test')->shouldReturn($this);
        $this->getConfig('test')->shouldReturn('Test');
    }
    
}
