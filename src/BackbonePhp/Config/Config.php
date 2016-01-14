<?php

namespace BackbonePhp\Config;

use BackbonePhp\Utils\File;

/**
 * BackbonePHP Configuration class
 * 
 */
class Config
{
    
    /**
     * @var array Configuration data
     */
    protected $data = null;
    
    
    public function __construct()
    {
        $this->data = new \stdClass();
    }
    
    /**
     * Sets a config option
     * 
     * @param str $name Option name
     * @param mixed $value Option value
     * @return Config Config instance
     */
    public function set($name, $value)
    {
        $this->data->$name = $value;
        return $this;
    }

    /**
     * Returns a config option
     * 
     * @param str $name Option name
     * @param mixed $default Default return value
     * @return mixed|null Option value (if set) or default value (if provided) or null
     */
    public function get($name, $default = null)
    {
       return isset($this->data->$name) ? $this->data->$name : $default;
    }
    
    /**
     * Loads and applies configuration data from a (JSON) file
     * 
     * @param string $path Path to configuration file
     * @param array $mergeFields config options that should be merged, not replaced during `Config::load`
     * @return Config Config instance
     */
    public function load($path, $mergeFields = array())
    {
        foreach (File::loadJson($path) as $key => $value) {
            if (in_array($key, $mergeFields) && isset($this->data->$key)) {
                $this->merge($key, $value);
            } else {
                $this->data->$key = $value;
            }
        }
        return $this;
    }
    
    /**
     * Merges the given config option with an existing one
     * 
     * @param str $name Option name
     * @param mixed $value Option value
     */
    public function merge($name, $value)
    {
        if (is_array($value)) {
            $this->data->$name = array_merge((array) $this->data->$name, $value);
        } else if (is_object($value)) {
            $this->data->$name = (object) $this->data->$name;
            foreach ($value as $subKey => $subValue) {
                $this->data->$name->$subKey = $subValue;
            }
        }
        return $this;
    }

}
