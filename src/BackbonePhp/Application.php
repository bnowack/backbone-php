<?php

namespace BackbonePhp;

/**
 * BackbonePHP application class
 * 
 * Example usage (with index.php in the app root):
 * 
 *  (new BackbonePhp\Application())
 *      ->setConfig('fileBase', __DIR__ . '/')
 *      ->setConfig('webBase', '/app-directory/') // use only when app is not deployed to web root!
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
     * Instantiates the application
     * 
     * @param Config $config Configuration object
     */
    public function __construct($config = null)
    {
        $this->config = $config ?: new Config();
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

}
