<?php

namespace src\BackbonePhp\Application;

use PhpSpec\ObjectBehavior;
use SpecHelper;

class ApplicationSpec extends ObjectBehavior
{
    
    function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Application\Application');
    }
    
    public function it_sets_and_gets_a_config_option()
    {
        $this->setConfig('test', 'Test')->shouldReturn($this);
        $this->getConfig('test')->shouldReturn('Test');
    }
    
    public function it_loads_a_config_file()
    {
        $this->loadConfig(SpecHelper::fixturesPath() . 'config-1.json')->shouldReturn($this);
        $this->getConfig('foo')->shouldReturn('bar');
    }
    
    function it_throws_an_exception_when_loading_a_non_existing_or_invalid_config_file()
    {
        $this->shouldThrow('\BackbonePhp\Exception\FileNotFoundException')->duringLoadConfig(SpecHelper::fixturesPath() . 'does-not-exist.json');
        $this->shouldThrow('\BackbonePhp\Exception\InvalidJsonException')->duringLoadConfig(SpecHelper::fixturesPath() . 'invalid-json.txt');
    }
    
    public function it_dispatches_a_request()
    {
        $this->dispatchRequest()->shouldReturn($this);
    }
    
    public function it_creates_a_response()
    {
        $this->getResponse()->shouldhaveType('BackbonePhp\Response\Response');
        $this->dispatchRequest()->getResponse()->shouldhaveType('BackbonePhp\Response\Response');
    }
    
}
