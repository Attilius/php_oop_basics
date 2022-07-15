<?php

class Response
{
    private $body;
    private $headers;
    private $statusCode;
    private $reasonPhrase;

    public function __construct(string $body, array $headers, int $statusCode, string $reasonPhrase)
    {
        $this->body = $body;
        $this->headers = $headers;
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
    }

    /**
     * @return string
     */
    public function getBody(): string
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
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }


}