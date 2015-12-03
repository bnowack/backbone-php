<?php

namespace BackbonePhp;

class Response
{

    public $protocol = 'HTTP/1.1';
    
    protected $code = '200';
    protected $cookies = [];
    protected $headers = [];
    protected $body = '';

    /**
     * Instantiates the response
     * 
     * @param Config $config Configuration object
     */
    public function __construct(Config $config = null)
    {
        $this->config = $config ?: new Config();
    }

    /**
     * Sets the response code
     * 
     * @param int $code Response code, e.g. 200
     * @return \BackbonePhp\Response response instance
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    
    /**
     * Returns the response code
     * 
     * @return int Response code, e.g. 200
     */
    public function getCode() {
        return $this->code;
    }
    
    /**
     * Sets a response header
     * 
     * @param str $name Header name
     * @param mixed $value Header value as array or string
     * @return \BackbonePhp\Response Response instance
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }
    
    /**
     * Returns a response header's value
     * 
     * @param str $name Header name
     * @return str Header value (array or string)
     */
    public function getHeader($name)
    {
        foreach ($this->headers as $headerName => $value) {
            if (strtolower($name) === strtolower($headerName)) {
                return $value;
            }
        }
        return null;
    }
    
    /**
     * Sets the response body
     * 
     * @param mixed $body Response body as array, object, or string
     * @return \BackbonePhp\Response response instance
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }
    
    /**
     * Returns the response body
     * 
     * @return mixed Response body (array, object, or string)
     */
    public function getBody()
    {
        return $this->body;
    }
    
    /**
     * Sends the response cookies and headers
     * 
     * @return \BackbonePhp\Response response instance
     */
    public function sendHeaders()
    {
        header("$this->protocol $this->code");
        // cookies
        foreach ($this->cookies as $cookie) {
            setCookie($cookie->name, $cookie->value, $cookie->expire, $cookie->path);
        }
        // headers
        foreach ($this->headers as $headerName => $values) {
            if (!is_array($values)) {
                $values = array($values);
            }
            foreach ($values as $value) {
                header("$headerName: $value");
            }
        }
        return $this;
    }
    
    /**
     * Sends the response body
     * 
     * @return \BackbonePhp\Response response instance
     */
    public function sendBody()
    {
        $body = $this->getBody();
        if (!is_string($body)) {
            $body = json_encode($body, JSON_PRETTY_PRINT && JSON_FORCE_OBJECT);
        }
        echo $body;
        flush();
        return $this;
    }
    
    /**
     * Checks if the response has a successful code (2xx)
     * 
     * @return bool TRUE if successful, FALSE otherwise
     */
    public function isSuccessful() {
        return !!preg_match('/^2/', strval($this->code));
    }

}
