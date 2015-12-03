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
 *      ->loadConfig('config/server.json')
 *      ->loadConfig('config/models.json')
 *      ->loadConfig('config/permissions.json')
 *      ->loadConfig('config/groups.json')
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
        $normalizedValue = $this->normalizeConfigOption($option, $value);
        $this->config->set($option, $normalizedValue);
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
     * Normalizes a config option
     * 
     * @param string $option Config option name
     * @param mixed $value Value of the config option
     * @return mixed $value Normalized value of the config option
     */
    protected function normalizeConfigOption($option, $value)
    {
        // make sure fileBase and webBase have a trailing slash
        if (in_array($option, array('fileBase', 'webBase'))) {
            return rtrim($value, '/') . '/';
        }
        return $value;
    }
    
    /**
     * Loads and applies configuration data from a (JSON) file
     * 
     * @param string $path Path to configuration file, relative to self::fileBase
     * @return \BackbonePhp\Application Application instance
     */
    public function loadConfig($path)
    {
        $mergeFields = array('permissions', 'groups', 'models');
        $this->config->load($this->config->get('fileBase') . $path, $mergeFields);
        return $this;
    }
}
