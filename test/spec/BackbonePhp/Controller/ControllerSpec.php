<?php

namespace spec\BackbonePhp\Controller;

use PhpSpec\ObjectBehavior;
use spec\Spec;

use BackbonePhp\Config\Config;
use BackbonePhp\Request\Request;
use BackbonePhp\Response\Response;

use PHPUnit_Framework_TestCase as Assertions;

class ControllerSpec extends ObjectBehavior
{
    
    public function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Controller\Controller');
    }
    
    public function it_has_a_config_object()
    {
        $this->config->shouldHaveType('BackbonePhp\Config\Config');
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
    
    public function it_support_response_code_and_type_in_template_requests()
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
            "model" => (object)[
                "pageTemplate" => "/test/fixtures/index.html.tpl",
                "pageTitle" => 'test',
                "responseType" => 'application/test',
                "responseCode" => 123,
            ],
            "path" => "/test",
            "type" => "template",
            "template" => "/test/fixtures/static-body.html.tpl"
        ];
        $this->handleTemplateRouteRequest($request, $response, $route)->shouldReturn($this);
        Assertions::assertEquals('application/test', $response->getHeader('Content-Type'), 'should have specified content type');
        Assertions::assertEquals('123', $response->getCode(), 'should have specified response code');
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
        Assertions::assertContains('<title>page - app</title>', $response->getBody(), 'should have page title and app title');

        // request with empty page title
        $route->model->pageTitle = null;
        $this->handleTemplateRouteRequest($request, $response, $route);
        Assertions::assertContains('<title>app</title>', $response->getBody(), 'should have app title only');

        // request with empty app title
        $route->model->pageTitle = 'page';
        $config->set('appTitle', null);
        $this->handleTemplateRouteRequest($request, $response, $route);
        Assertions::assertContains('<title>page</title>', $response->getBody(), 'should have page title only');
    }
    
}
