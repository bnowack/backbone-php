<?php

namespace BackbonePhp\Application;

use BackbonePhp\Config\Config;
use BackbonePhp\Router\Router;
use BackbonePhp\Request\Request;
use BackbonePhp\Response\Response;

/**
 * BackbonePHP application class
 * 
 * Example usage:
 * 
 *  (new BackbonePhp\Application())
 *      ->loadConfig(BACKBONEPHP_APP_DIR . 'src/config/default-models.json')
 *      ->loadConfig(BACKBONEPHP_APP_DIR . 'config/server.json')
 *      ->loadConfig(BACKBONEPHP_APP_DIR . 'config/models.json')
 *      ->loadConfig(BACKBONEPHP_APP_DIR . 'config/permissions.json')
 *      ->loadConfig(BACKBONEPHP_APP_DIR . 'config/groups.json')
 *  ;
 * 
 */
class Application
{
    
    /**
     * @var Config Configuration object  
     */
    protected $config;
    
    /**
     * @var Request Request object  
     */
    public $request;
    
    /**
     * @var Response Response object  
     */
    public $response;
    
    /**
     * @var Router Router object  
     */
    protected $router;
    
    /**
     * Instantiates the application
     * 
     * @param Config $config Configuration object
     */
    public function __construct($config = null)
    {
        $this->config = $config ?: new Config();
        $this->router = new Router($this->config);
    }
    
    /**
     * Sets a config option
     * 
     * @param string $option Config option name
     * @param mixed $value Value for the config option
     * @return \BackbonePhp\Application
     */
    public function setConfig($option, $value)
    {
        $this->config->set($option, $value);
        return $this;
    }

    /**
     * Returns a config option
     * 
     * @param string $option Config option name
     * @return mixed|null Option value or null if not set
     */
    public function getConfig($option)
    {
        return $this->config->get($option);
    }

    /**
     * Loads and applies configuration data from a (JSON) file
     * 
     * @param string $path Absolute path to configuration file
     * @param bool $optional Whether FileNotFound errors should be ignored
     * @return \BackbonePhp\Application Application instance
     */
    public function loadConfig($path, $optional = false)
    {
        $mergeFields = array('permissions', 'groups', 'models', 'templateFields');
        try {
            $this->config->load($path, $mergeFields, $optional);
        } catch (\Exception $ex) {
            if (!$optional) {
                throw $ex;
            }
        }
        return $this;
    }

    /**
     * Dispatches a client request
     * 
     * @param \BackbonePhp\Request $request Request object (optional)
     * @param \BackbonePhp\Response $response Response object (optional)
     * @return \BackbonePhp\Application Application instance
     */
    public function dispatchRequest($request = null, $response = null)
    {
        $this->request = $request ?: new Request($this->config);
        if (!$request) {
            $this->request->initializeFromEnvironment();
        }
        $this->response = $response ?: new Response($this->config);
        $this->router->dispatchRequest($this->request, $this->response);
        return $this;
    }
    
    /**
     * Returns (or creates and returns) the application's response object
     * 
     * @return \BackbonePhp\Response $response Response instance
     */
    public function getResponse()
    {
        if (!$this->response) {
            $this->response = new Response($this->config);
        }
        return $this->response;
    }

}
