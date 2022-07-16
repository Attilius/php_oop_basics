<?php

class Request
{
    private $body;
    private $headers;
    private $cookies;
    private $params;
    private $uri;
    private $method;

    public function __construct($uri, $method, $body = null, $headers = [], $cookies = [], $params = [])
    {
        $this->body = $body;
        $this->method = $method;
        $this->headers = $headers;
        $this->cookies = $cookies;
        $this->params = $params;
        $this->uri = $uri;
    }

    /**
     * @return mixed|null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return array|mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return array|mixed
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @return array|mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

}