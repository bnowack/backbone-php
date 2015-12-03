<?php

namespace BackbonePhp;

use BackbonePhp\Exception\UndefinedPropertyException;

/**
 * BackbonePHP Request Class
 */
class Request
{

    protected $base;
    protected $path;
    protected $cleanPath;
    protected $resourcePath;
    protected $extension;
    protected $pathParts;
    protected $method;
    protected $arguments;
    
    /**
     * Instantiates the request
     * 
     * @param Config $config Configuration object
     */
    public function __construct(Config $config = null)
    {
        $this->config = $config ?: new Config();
    }
    
    /**
     * Sets one of the known instance properties
     * 
     * @param string $property Property
     * @param mixed $value Value
     * @return \BackbonePhp\Request Self
     * @throws UndefinedPropertyException when the property is not defined
     */
    public function set($property, $value = null)
    {
        if (!property_exists($this, $property)) {
            throw new UndefinedPropertyException('Undefined Property: "' . $property . '"');
        }
        $this->$property = $value;
        return $this;
    }
    
    /**
     * Returns a property value
     * 
     * @param string $property
     * @return mixed Value
     * @throws UndefinedPropertyException when the property is not defined
     */
    public function get($property)
    {
        if (!property_exists($this, $property)) {
            throw new UndefinedPropertyException('Undefined Property: "' . $property . '"');
        }
        return $this->$property;
    }
    
}
