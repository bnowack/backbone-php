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
    
}
