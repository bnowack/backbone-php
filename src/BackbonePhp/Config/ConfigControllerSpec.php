<?php

namespace src\BackbonePhp\Config;

use PhpSpec\ObjectBehavior;
use SpecHelper;

use BackbonePhp\Config\Config;
use BackbonePhp\Request\Request;
use BackbonePhp\Response\Response;

use PHPUnit_Framework_TestCase as Assertions;

class ConfigControllerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Config\ConfigController');
    }
    
    public function it_generates_a_frontend_config_object()
    {
        $config = new Config();
        $config->load(SpecHelper::rootPath() . 'src/BackbonePhp/Application/config/application.json');
        $config->load(SpecHelper::rootPath() . 'src/BackbonePhp/Application/config/groups.json');
        $config->load(SpecHelper::rootPath() . 'src/BackbonePhp/Application/config/models.json');
        $config->load(SpecHelper::rootPath() . 'src/BackbonePhp/Application/config/permissions.json');
        $this->config = $config;
        
        $request = new Request();
        $response = new Response();
        $route = (object)[];
        
        $this->handleFrontendConfigRequest($request, $response, $route)->shouldReturn($this);
        
        Assertions::assertEquals('application/json', $response->getHeader('Content-Type'), 'should set content type to JSON');
        Assertions::assertEquals('BackbonePHP', $response->getBody()->appName, 'should set status field');
        Assertions::assertFalse(isset($response->getBody()->groups), 'should net expose user groups');
        Assertions::assertFalse(isset($response->getBody()->permissions), 'should net expose permissions');
    }
}
