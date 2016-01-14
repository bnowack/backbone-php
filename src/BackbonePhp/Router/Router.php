<?php

namespace BackbonePhp\Router;

use BackbonePhp\Exception\FileNotFoundException;
use BackbonePhp\Exception\MethodNotFoundException;
use BackbonePhp\Controller\Controller;
use BackbonePhp\Config\Config;
use BackbonePhp\Request\Request;
use BackbonePhp\Response\Response;

/**
 * BackbonePHP Router Class
 */
class Router
{

    /**
     * @var Config Configuration object
     */
    public $config;
    
    /**
     *
     * @var Request Request
     */
    protected $request;
    
    /**
     *
     * @var Response
     */
    protected $response;

    /**
     * Instantiates the router
     * 
     * @param Config $config Configuration object
     */
    public function __construct(Config $config = null)
    {
        $this->config = $config ?: new Config();
    }
    
    /**
     * Detects and calls the configured handlers matching the given request
     * 
     * @param Request $request Request
     * @param Response $response Response
     * @return Router Router instance
     */
    public function dispatchRequest(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $routes = $this->getRoutes();
        foreach ($routes as $route) {
            if (!$this->matchRequestPath($route)) {
                continue;
            }
            // process matching route
            if ($route->type === 'template') {
                $this->handleTemplateRequest($route);
            } else if ($route->type === 'call') {
                $this->handleCallRequest($route);
            }
        }
        return $this;
    }
    
    /**
     * Extracts all routes from the configuration
     * 
     * @return array A list of routes, each containing "path", "type", "model" and type handler properties
     */
    protected function getRoutes()
    {
        $result = array();
        $models = $this->config->get('models', array());
        foreach ($models as $model) {
            $routes = isset($model->routes) ? $model->routes : array();
            foreach ($routes as $path => $handlerString) {
                $type = $this->getRouteType($handlerString); // call | template
                $result[] = (object) [
                    'path' => $path,
                    'type' => $type,
                    $type => $handlerString,
                    'model' => $model
                ];
            }
        }
        return $result;
    }
    
    /**
     * Detects the route type depending on the provided handler string
     * 
     * @param string $handlerString Route handler as defined in config
     * @return string Route (handler) type, "call" or "template"
     */
    protected function getRouteType($handlerString)
    {
        $result = null;
        // class + method detection => controller call
        if (preg_match('/.+::.+/', $handlerString)) {
            $result = 'call';
        }
        // path with filename extension
        else if (preg_match('/\/.+\./', $handlerString)) {
            $result = 'template';
        }
        return $result;
    }
    
    /**
     * Checks whether the given route path matches the current request path and sets route parameters
     * 
     * @param \stdClass $route Route object
     * @return bool TRUE if the route matches the request path, FALSE otherwise
     */
    protected function matchRequestPath($route)
    {
        $this->buildMatchPattern($route);
        $requestPath = $this->request->get('resourcePath');
        $matches = array();
        if (preg_match("/^$route->pattern$/", $requestPath, $matches)) {
            $this->buildParameters($route, $matches);
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Derives and sets a regular expression pattern from the given route's path definition
     * 
     * @param \stdClass $route Route object
     * @return Router Router instance
     */
    protected function buildMatchPattern($route)
    {
        $routePattern = $route->path;
        $fields = isset($route->model->fields) ? $route->model->fields : (object) [];
        foreach ($fields as $fieldName => $fieldSpec) {
            if (isset($fieldSpec->format)) {
                $routePattern = preg_replace('/(:' . $fieldName . ')([^a-z]|$)/', $fieldSpec->format . '\\2', $routePattern);
            } else if (isset($fieldSpec->type) && $fieldSpec->type === 'integer') {
                $routePattern = preg_replace('/(:' . $fieldName . ')([^a-z]|$)/', '[0-9]+\\2', $routePattern);
            }
        }
        $route->pattern = addcslashes($routePattern, '\/');
        return $this;
    }
    
    /**
     * Extracts and sets route parameters from path matches
     * 
     * Example: "/path/(:myParam)" with "/path/foo" sets "$route->params->myParam" to "foo"
     * 
     * @param \stdClass $route Route object
     * @param array $pathMatches Matches for the given route against the current request
     * @return Router Router instance
     */
    protected function buildParameters($route, $pathMatches)
    {
        $route->params = (object)[];
        $routeParts = array();
        $fields = isset($route->model->fields) ? $route->model->fields : (object) [];
        if (preg_match_all('/\(:([^\)]+)\)/', $route->path, $routeParts)) {
            foreach ($routeParts[1] as $pos => $paramName) {
                $paramValue = isset($pathMatches[$pos + 1])
                    ? $pathMatches[$pos + 1]
                    : null
                ;
                $paramType = isset($fields->$paramName) && isset($fields->$paramName->type)
                    ? $fields->$paramName->type
                    : null
                ;
                if ($paramType === 'integer') {
                    $paramValue = (int) $paramValue;
                }
                $route->params->$paramName = $paramValue;
            }
        }
        return $this;
    }
    
    /**
     * Handles a template request (fills a page template with the body template specified in the route config)
     * 
     * @param \stdClass $route Route object
     * @return Router Router instance
     */
    protected function handleTemplateRequest($route)
    {
        $controller = new Controller($this->config);
        $controller->handleTemplateRouteRequest($this->request, $this->response, $route);
        return $this;
    }
        
    /**
     * Handles a controller call request
     * 
     * @param \stdClass $route Route object
     * @return Router Router instance
     */
    protected function handleCallRequest($route)
    {
        $matches = null;
        preg_match('/^(.+)::(.+)$/', $route->call, $matches);
        $className = $matches[1];
        $methodName = $matches[2];
        if (!class_exists($className)) {
            throw new FileNotFoundException('Class file for "' . $className . '" not found');
        }
        $object = new $className($this->config);
        if (!method_exists($object, $methodName)) {
            throw new MethodNotFoundException('Class method "' . $methodName . '" not found in class ' . $className . '"');
        }
        $object->$methodName($this->request, $this->response, $route);
    }
    
}
