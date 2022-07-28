<?php

namespace Response;

class Response implements ResponseInterface
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

    public function emitBody()
    {
        echo $this->body;
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

    /**
     * @param $url
     * @return Response
     */
    public static function redirect($url): Response
    {
        return new Response("",[
            "Location" => $url
        ], 302, "Found");
    }
}