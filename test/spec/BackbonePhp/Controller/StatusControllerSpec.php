<?php

namespace spec\BackbonePhp\Controller;

use PhpSpec\ObjectBehavior;
use spec\Spec;

use BackbonePhp\Config;
use BackbonePhp\Request;
use BackbonePhp\Response;

use PHPUnit_Framework_TestCase as Assertions;

class StatusControllerSpec extends ObjectBehavior
{
    
    public function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Controller\StatusController');
    }
    
    public function it_generates_a_status_object()
    {
        $config = new Config();
        $config->set('fileBase', Spec::rootPath());
        $config->load(Spec::rootPath() . 'src/BackbonePhp/config/default-models.json');
        $this->config = $config;
        
        $request = new Request();
        $response = new Response();
        $route = (object)[];
        
        $this->handleStatusRequest($request, $response, $route)->shouldReturn($this);
        
        Assertions::assertEquals('application/json', $response->getHeader('Content-Type'), 'should set content type to JSON');
        Assertions::assertEquals('ok', $response->getBody()->status, 'should set status field');
        Assertions::assertTrue(is_int($response->getBody()->timestamp), 'should set timestamp field');
    }
    
}
