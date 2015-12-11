<?php

namespace spec\BackbonePhp;

use PhpSpec\ObjectBehavior;

class RequestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Request');
    }
    
    function it_sets_a_method()
    {
        $this->setMethod('GET')->get('method')->shouldReturn('GET');
    }
    
    function it_sets_a_path()
    {
        $this->setPath('/test')->get('path')->shouldReturn('/test');
    }
    
    function it_generates_a_clean_path()
    {
        $this->setPath('/test.html?a=b')->get('cleanPath')->shouldReturn('/test.html');
    }
    
    function it_generates_a_resource_path()
    {
        $this->setPath('/test.html?a=b')->get('resourcePath')->shouldReturn('/test');
    }
    
    function it_generates_an_extension()
    {
        $this->setPath('/test.html?a=b')->get('extension')->shouldReturn('html');
    }
    
    function it_generates_path_sections()
    {
        $this->setPath('/foo/bar/baz.html?a=b')->get('pathSections')->shouldReturn(["foo", "bar", "baz"]);
    }
    
}
