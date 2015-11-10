<?php

namespace spec\BackbonePhp;

use PhpSpec\ObjectBehavior;

class ConfigSpec extends ObjectBehavior
{

    public function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Config');
    }
    
}
