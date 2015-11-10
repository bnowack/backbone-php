<?php

namespace BackbonePhp;

/**
 * BackbonePHP Configuration class
 * 
 */
class Config
{
    
    /**
     * @var array Configuration data
     */
    protected $data = array();
    
    /**
     * Sets a config option
     * 
     * @param str $name Option name
     * @param mixed $value Option value
     * @return \BackbonePhp\Config 
     */
    public function set($name, $value)
    {
        $this->data[$name] = $value;
        return $this;
    }

    /**
     * Returns a config option
     * 
     * @param str $name Option name
     * @return mixed|null Option value or null if not set
     */
    public function get($name)
    {
       return isset($this->data[$name]) ? $this->data[$name] : null;
    }
    
    /**
     * Loads and applies configuration data from a (JSON) file
     * 
     * @param string $path Path to configuration file
     * @param array $mergeFields config options that should be merged, not replaced during `Config::load`
     * @return \BackbonePhp\Config 
     */
    public function load($path, $mergeFields = array())
    {
        foreach (File::loadJson($path) as $key => $value) {
            if (in_array($key, $mergeFields) && isset($this->data[$key])) {
                $this->data[$key] = array_merge($this->data[$key], $value);
            } else {
                $this->data[$key] = $value;
            }
        }
        return $this;
    }

}
