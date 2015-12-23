<?php

namespace spec\BackbonePhp;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\Spec;

use BackbonePhp\Request;

class ApplicationSpec extends ObjectBehavior
{
    
    function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Application');
    }
    
    public function it_sets_and_gets_a_config_option()
    {
        $this->setConfig('test', 'Test')->shouldReturn($this);
        $this->getConfig('test')->shouldReturn('Test');
    }
    
    public function it_normalizes_base_config_options()
    {
        // trailing slash on fileBase
        $this->setConfig('fileBase', 'path/to/dir')->getConfig('fileBase')->shouldReturn('path/to/dir/');
        $this->setConfig('fileBase', 'path/to/dir/')->getConfig('fileBase')->shouldReturn('path/to/dir/');
        
        // trailing slash on webBase
        $this->setConfig('webBase', 'path/from/root/')->getConfig('webBase')->shouldReturn('path/from/root/');
        $this->setConfig('webBase', 'path/from/root')->getConfig('webBase')->shouldReturn('path/from/root/');
    }
        
    public function it_loads_a_config_file()
    {
        $this->setConfig('fileBase', Spec::testsPath());
        $this->loadConfig('fixtures/config-1.json')->shouldReturn($this);
        $this->getConfig('foo')->shouldReturn('bar');
    }
    
    function it_throws_an_exception_when_loading_a_non_existing_or_invalid_config_file()
    {
        $this->setConfig('fileBase', Spec::testsPath());
        $this->shouldThrow('\BackbonePhp\Exception\FileNotFoundException')->duringLoadConfig('fixtures/does-not-exist.json');
        $this->shouldThrow('\BackbonePhp\Exception\InvalidJsonException')->duringLoadConfig('fixtures/invalid-json.txt');
    }
    
}
