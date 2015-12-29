<?php

namespace spec\BackbonePhp\Controller;

use PhpSpec\ObjectBehavior;
use spec\Spec;

use BackbonePhp\Config;
use BackbonePhp\Request;
use BackbonePhp\Response;

use PHPUnit_Framework_TestCase as Assertions;

class ControllerSpec extends ObjectBehavior
{
    
    public function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Controller\Controller');
    }
    
    public function it_has_a_config_object()
    {
        $this->config->shouldHaveType('BackbonePhp\Config');
    }
    
    public function it_handles_a_template_request()
    {
        // config
        $config = new Config();
        $config->set('fileBase', Spec::rootPath());
        $this->config = $config;
        
        $request = new Request();
        $response = new Response();
        
        $config->set('appTitle', 'test');
        $request->setPath('/test');
        
        $route = (object)[
            "path" => "/test",
            "type" => "template",
            "template" => "/test/fixtures/static-body.html.tpl",
            "model" => (object)[
                "pageTemplate" => "/test/fixtures/index.html.tpl",
                "pageTitle" => 'test'
            ]
        ];
        $this->handleTemplateRouteRequest($request, $response, $route)->shouldReturn($this);
    }
    
    public function it_adds_the_app_title_to_the_page_title()
    {
        // init
        $config = new Config();
        $config->set('fileBase', Spec::rootPath());
        $this->config = $config;
        
        $request = new Request();
        $response = new Response();
        
        // request with appended app title
        $config->set('appTitle', 'app');
        $request->setPath('/test');
        
        $route = (object)[
            "path" => "/test",
            "type" => "template",
            "template" => "/test/fixtures/static-body.html.tpl",
            "model" => (object)[
                "pageTemplate" => "/test/fixtures/index.html.tpl",
                "pageTitle" => 'page'
            ]
        ];
        $this->handleTemplateRouteRequest($request, $response, $route);
        $actual1 = $response->getBody();
        $expected1 = '<title>page - app</title>';
        Assertions::assertContains($expected1, $actual1, 'should have page title and app title');

        // request with empty page title
        $route->model->pageTitle = null;
        $this->handleTemplateRouteRequest($request, $response, $route);
        $actual2 = $response->getBody();
        $expected2 = '<title>app</title>';
        Assertions::assertContains($expected2, $actual2, 'should have app title only');

        // request with empty app title
        $route->model->pageTitle = 'page';
        $config->set('appTitle', null);
        $this->handleTemplateRouteRequest($request, $response, $route);
        $actual3 = $response->getBody();
        $expected3 = '<title>page</title>';
        Assertions::assertContains($expected3, $actual3, 'should have page title only');
    }
    
}
