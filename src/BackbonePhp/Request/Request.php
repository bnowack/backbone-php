<?php

namespace BackbonePhp\Request;

use BackbonePhp\Exception\UndefinedPropertyException;
use BackbonePhp\Config\Config;

/**
 * BackbonePHP Request Class
 */
class Request
{

    /**
     * @var Config Configuration object  
     */
    public $config;

    /**
     * @var stdClass Request environment, e.g. (object) [
     *      'get' => (object) $_GET, 
     *      'post' => (object) $_POST, 
     *      'cookie' => (object) $_COOKIE, 
     *      'files' => (object) $_FILES, 
     *      'server' => (object) $_SERVER];
     */
    protected $environment;
    
    /**
     * @var Array Request headers
     */
    protected $headers;
    
    /**
     * @var string Request method, e.g. GET
     */
    protected $method;
    
    /**
     * @var string Request path (complete), e.g. /blog/2015-12-24-merry-xmas.html?foo=bar
     */
    protected $path;
    
    /**
     * @var string Request path (without query string), e.g. /blog/2015-12-24-merry-xmas.html
     */
    protected $cleanPath;
    
    /**
     * @var string Request resource path (without extension), e.g. /blog/2015-12-24-merry-xmas
     */
    protected $resourcePath;    // e.g. /blog/2015-12-24-merry-xmas
    
    /**
     * @var string Request extension (if any), e.g. html
     */
    protected $extension;
    
    /**
     * @var Array Request path sections, e.g. ["blog", "2015-12-24-merry-xmas"]
     */
    protected $pathSections;
    
    /**
     * @var stdClass Request query arguments, e.g. (object)["foo" => "bar"]
     */
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
     * Sets the request environment object and initialises core request properties (path, cleanPath, etc.)
     * 
     * @param stdClass $environment Request environment, e.g. (object) ['get' => (object) $_GET, 'post' => (object) $_POST]; 
     * @return \BackbonePhp\Request Request instance
     */
    public function initializeFromEnvironment($environment = null)
    {
        $this->environment = $environment ?: (object) [
            'get' => (object) $_GET,
            'post' => (object) $_POST,
            'cookie' => (object) $_COOKIE,
            'files' => (object) $_FILES,
            'server' => isset($_SERVER) ? (object) $_SERVER : (object)[]
        ];
        // extract path
        $appBase = $this->config->get('appBase', '/');
        $appBaseRegex = '/^' . preg_quote($appBase, '/') . '/';
        $requestUri = $this->getEnvironmentVariable('server', 'REQUEST_URI') ?: '/';
        $trimmedPath = ltrim(preg_replace($appBaseRegex, '', $requestUri), '/'); 
        $path = '/' . $trimmedPath;
        $this->setPath($path);
        return $this;
    }
    
    /**
     * Sets the request method
     * 
     * @param string $method Request method, e.g. "GET"
     * @return \BackbonePhp\Request Request instance
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }
    
    /**
     * Sets the request path and extracts request properties such as cleanPath, extension, etc.
     * 
     * @param string $path Request path, excluding the appBase (such as "/myAppDir/"), with a trailing slash, e.g. "/blog/2015-12-24-merry-xmas.html?foo=bar"
     * @return \BackbonePhp\Request Request instance
     */
    public function setPath($path)
    {
        $matches = null;
        $this->path = $path;
        $this->cleanPath = preg_replace('/\?.*$/', '', $this->path);
        $this->resourcePath = preg_replace('/\..*$/', '', $this->cleanPath);
        $this->extension = preg_match('/^.*\.(.*)$/', $this->cleanPath, $matches)
            ? $matches[1]
            : null;
        $this->pathSections = explode('/', trim($this->resourcePath, '/'));
        $queryString = preg_replace('/^.*\?/', '', $this->path);
        $this->arguments = $this->parseQueryString($queryString);
        return $this;
    }
    
    /**
     * Parses a query string
     * 
     * @param string $queryString Query string, e.g. a=1&a=2&b=3
     * @return stdClass Query arguments objects
     */
    protected function parseQueryString($queryString)
    {
        $result = (object)[];
        $argStrings = preg_split('/\&/', $queryString);
        $matches = array();
        foreach ($argStrings as $argString) {
            if (!preg_match('/^([^=]+)=(.*)$/', $argString, $matches) || $matches[2] === '') {
                continue;
            }
            $argName = $matches[1];
            $argValue = urldecode($matches[2]);
            if (!isset($result->$argName)) {
                $result->$argName = $argValue;
            } elseif (is_array($result->$argName)) {
                $result->{$argName}[] = $argValue;
            } else {
                $result->$argName = [$result->$argName, $argValue];
            }
        }
        return $result;
    }
    
    /**
     * Returns a request property
     * 
     * @param string $property Request property
     * @return mixed Request property value
     * @throws UndefinedPropertyException when the property is not defined
     */
    public function get($property)
    {
        if (!property_exists($this, $property)) {
            throw new UndefinedPropertyException('Undefined Property: "' . $property . '"');
        }
        return $this->$property;
    }
    
    /**
     * Returns an environment property, if defined.
     * 
     * e.g. $this->getEnvironmentVariable('server', 'REQUEST_URI');
     * 
     * @param string $category Environment category: (get|post|cookie|files|server)
     * @param string $name Property name
     * @return mixed Property value
     */
    public function getEnvironmentVariable($category, $name, $default = null) {
        if (!isset($this->environment->$category)) {
            return $default;
        }
        if (!isset($this->environment->$category->$name)) {
            return $default;
        }
        return $this->environment->$category->$name;
    }

}
