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
    
    public function it_should_normalize_base_config_options()
    {
        // trailing slash on fileBase
        $this->setConfig('fileBase', 'path/to/dir')->getConfig('fileBase')->shouldReturn('path/to/dir/');
        $this->setConfig('fileBase', 'path/to/dir/')->getConfig('fileBase')->shouldReturn('path/to/dir/');
        
        // trailing slash on webBase
        $this->setConfig('webBase', 'path/from/root/')->getConfig('webBase')->shouldReturn('path/from/root/');
        $this->setConfig('webBase', 'path/from/root')->getConfig('webBase')->shouldReturn('path/from/root/');
    }
    
}
