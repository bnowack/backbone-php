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
    
    function it_throws_an_exception_fo_invalid_accessors()
    {
        $this->shouldThrow('BackbonePhp\Exception\UndefinedPropertyException')->duringGet('invalid');
    }
    
    function it_allows_environment_injection()
    {
        $env = (object)[
            'get' => (object) [
                'bar' => 'baz'
            ]
        ];
        $this->initializeFromEnvironment($env)->shouldReturn($this);
        $this->getEnvironmentVariable('get', 'bar')->shouldReturn('baz');
        $this->getEnvironmentVariable('get', 'undefined', 'default')->shouldReturn('default');
    }
    
    function it_auto_imports_the_script_environment()
    {
        $_GET['test'] = 'foo';
        $this->initializeFromEnvironment()->shouldReturn($this);
        $this->getEnvironmentVariable('get', 'test')->shouldReturn('foo');
    }
    
    function it_extracts_information_from_environment_path()
    {
        $this->config->set('webBase', '/foo/');
        $env = (object)[
            'server' => (object) [
                'REQUEST_URI' => '/foo/bar?baz=bat'
            ]
        ];
        $this->initializeFromEnvironment($env)->shouldReturn($this);
        $this->get('cleanPath')->shouldReturn('/bar');
        $this->get('arguments')->baz->shouldReturn('bat');
    }
    
    function it_extracts_repeated_arguments_as_array()
    {
        $this->config->set('webBase', '/');
        $env = (object)[
            'server' => (object) [
                'REQUEST_URI' => '/?foo=bar&foo=bar2&foo=bar3'
            ]
        ];
        $this
            ->initializeFromEnvironment($env)
            ->get('arguments')->foo->shouldReturn(['bar', 'bar2', 'bar3'])
        ;
    }
    
}
