<?php

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

    public function __construct(string $uri, string $method, SessionInterface $session, string $body = null, array $headers = [], array $cookies = [], array $params = [])
    {
        $this->body = $body;
        $this->method = $method;
        $this->headers = $headers;
        $this->cookies = $cookies;
        $this->params = $params;
        $this->uri = $uri;
        $this->session = $session;
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
}