<?php

namespace src\BackbonePhp\Status;

use PhpSpec\ObjectBehavior;
use SpecHelper;

use BackbonePhp\Config\Config;
use BackbonePhp\Request\Request;
use BackbonePhp\Response\Response;

use PHPUnit_Framework_TestCase as Assertions;

class StatusControllerSpec extends ObjectBehavior
{
    
    public function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Status\StatusController');
    }
    
    public function it_generates_a_status_object()
    {
        $config = new Config();
        $config->load(SpecHelper::rootPath() . 'src/BackbonePhp/Application/config/models.json');
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
