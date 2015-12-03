<?php

namespace BackbonePhp;

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
     * @var array
     */
    protected $routes = [];

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
     * @param \BackbonePhp\Request $request Request
     * @param \BackbonePhp\Response $response Response
     * @return \BackbonePhp\Router Router instance
     */
    public function dispatchRequest(Request $request, Response $response)
    {
        return $this;
    }    

}
