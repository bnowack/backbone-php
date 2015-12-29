<?php

namespace BackbonePhp\Controller;

use BackbonePhp\Config;
use BackbonePhp\Template;

/**
 * BackbonePHP Controller Class
 */
class Controller
{

    /**
     * @var Config Configuration object  
     */
    public $config;
    
    /**
     * Instantiates the controller
     * 
     * @param Config $config Configuration object
     */
    public function __construct(Config $config = null)
    {
        $this->config = $config ?: new Config();
    }
    
    /**
     * Processes a basic template route request
     * 
     * Renders a page template with the body template specified in the route config, sets the title etc.
     * 
     * @param \BackbonePhp\Request $request Request
     * @param \BackbonePhp\Response $response Response
     * @param \stdClass $route Route object
     * @return \BackbonePhp\Controller Controller instance
     */
    public function handleTemplateRouteRequest($request, $response, $route)
    {
        $pageTemplate = $route->model->pageTemplate;
        $pageTitle = $this->getFullPageTitle($route);
        $bodyTemplate = $route->template;
        $responseCode = isset($route->model->responseCode)
            ? $route->model->responseCode
            : 200
        ;
        $responseType = isset($route->model->responseType)
            ? $route->model->responseType
            : 'text/html; charset=UTF-8'
        ;
        $content = (new Template($this->config))
            ->setContent("{{$pageTemplate}}")
            ->set('path', $request->get('resourcePath'))
            ->set('pageTitle', $pageTitle)
            ->set('body', "{{$bodyTemplate}}")
            ->render()
            ->getContent()
        ;
        $response
            ->setCode($responseCode)
            ->setType($responseType)
            ->setBody($content)
        ;
        return $this;
    }
    
    /**
     * Generates a combined page title from configured app title and page title
     * 
     * @param \stdClass $route Route object
     * @return string Combined page title
     */
    protected function getFullPageTitle($route)
    {
        $pageTitle = isset($route->model->pageTitle)
            ? $route->model->pageTitle
            : ''
        ;
        $appTitle = isset($route->model->appTitle)
            ? $route->model->appTitle
            : $this->config->get('appTitle', '')
        ;
        $titleGlue = $this->config->get('pageTitleDelimiter', ' - ');
        return ($pageTitle && $appTitle)
            ? $pageTitle . $titleGlue . $appTitle
            : $pageTitle . $appTitle
        ;
    }

}
