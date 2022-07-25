<?php
namespace Request;

use Session\SessionInterface;

class Request
{
    private string $body;
    private array $headers;
    private array $cookies;
    private array $params;
    private string $uri;
    private string $method;
    private SessionInterface $session;
    private array $files;

    public function __construct(string $uri, string $method, SessionInterface $session, string $body = null,
                                array $headers = [], array $cookies = [], array $params = [], array $files = [])
    {
        $this->body = $body;
        $this->method = $method;
        $this->headers = $headers;
        $this->cookies = $cookies;
        $this->params = $params;
        $this->uri = $uri;
        $this->session = $session;
        $this->files = $files;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getCookies(): array
    {
        return $this->cookies;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    public function getParam($fieldName)
    {
        if (!array_key_exists($fieldName, $this->params)){
            return null;
        }
        return $this->params[$fieldName];
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return SessionInterface
     */
    public function getSession(): SessionInterface
    {
        return $this->session;
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    public function getFile($fieldName)
    {
        if (!array_key_exists($fieldName, $this->files)){
            return null;
        }
        return $this->files[$fieldName];
    }
}