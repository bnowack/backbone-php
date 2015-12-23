<?php

namespace spec\BackbonePhp;

use PhpSpec\ObjectBehavior;
use spec\Spec;

use BackbonePhp\Config;
use BackbonePhp\Request;
use BackbonePhp\Response;

use PHPUnit_Framework_TestCase as Assertions;

class RouterSpec extends ObjectBehavior
{

    protected function setConfig()
    {
        $config = new Config();
        $config->load(Spec::fixturesPath() . 'router-config.json');
        $config->set('fileBase', Spec::rootPath());
        $this->config = $config;
    }
    
    public function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Router');
    }
    
    public function it_has_a_config_object()
    {
        $this->config->shouldHaveType('BackbonePhp\Config');
    }
    
    public function it_dispatches_a_request()
    {
        $request = new Request();
        $response = new Response();
        $this->dispatchRequest($request, $response)->shouldReturn($this);
    }
    
    public function it_dispatches_a_static_template_request()
    {
        // init
        $this->setConfig();
        $request = new Request($this->object->getWrappedObject()->config);
        $response = new Response($this->object->getWrappedObject()->config);
        
        // static request
        $request->setPath('/test/static');
        $this->dispatchRequest($request, $response);
        $actual = $response->getBody();
        
        $expectedBody = '<h1>Hello Static</h1>';
        Assertions::assertContains($expectedBody, $actual, 'should inject body template');
        
        $expectedMarkup = '<html>';
        Assertions::assertContains($expectedMarkup, $actual, 'should generate page container');
    }
    
    public function it_dispatches_a_controller_call_request()
    {
        // init
        $this->setConfig();
        $request = new Request($this->object->getWrappedObject()->config);
        $response = new Response($this->object->getWrappedObject()->config);
        
        // controller request
        $request->setPath('/test/plain-call');
        $this->dispatchRequest($request, $response);
        $actual = $response->getBody();
        $expected = 'Plain test';
        Assertions::assertEquals($expected, $actual, 'should be response from controller');
    }
    
    public function it_dispatches_a_controller_call_request_with_route_parameters()
    {
        // init
        $this->setConfig();
        $request = new Request($this->object->getWrappedObject()->config);
        $response = new Response($this->object->getWrappedObject()->config);
        
        // controller request
        $request->setPath('/test/2015');
        $this->dispatchRequest($request, $response);
        $actual1 = $response->getBody();
        $expected1 = 'Dynamic 2015';
        Assertions::assertEquals($expected1, $actual1, 'should be parametrised response from controller');
        
        // controller request
        $request->setPath('/test/2016');
        $this->dispatchRequest($request, $response);
        $actual2 = $response->getBody();
        $expected2 = 'Dynamic 2016';
        Assertions::assertEquals($expected2, $actual2, 'should be parametrised response from controller');
    }
    
    public function it_throws_exceptions_for_invalid_controller_calls()
    {
        // init
        $this->setConfig();
        $request = new Request($this->object->getWrappedObject()->config);
        $response = new Response($this->object->getWrappedObject()->config);
        
        // invalid controller class request
        $request->setPath('/test/invalid/class');
        $this->shouldThrow('BackbonePhp\Exception\FileNotFoundException')->duringDispatchRequest($request, $response);
        
        // invalid controller method request
        $request->setPath('/test/invalid/method');
        $this->shouldThrow('BackbonePhp\Exception\MethodNotFoundException')->duringDispatchRequest($request, $response);
    }
    
}

class RouterSpecController {
    
    public function handlePlainStaticCall(Request $request, Response $response, $route)
    {
        $response->setBody('Plain test');
    }
    
    public function handlePlainDynamicCall(Request $request, Response $response, $route)
    {
        $year = $route->params->year;
        $response->setBody("Dynamic $year");
    }
    
}
