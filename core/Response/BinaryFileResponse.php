<?php

namespace Response;

class BinaryFileResponse implements ResponseInterface
{
    private string $fileName;
    private array $headers = [];
    private int $statusCode;
    private string $reasonPhrase;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        $this->headers = [
            "Content-Type" => mime_content_type($fileName),
            "Content-Length" => filesize($fileName)
        ];
        $this->statusCode = 200;
        $this->reasonPhrase = "Ok";
    }

    public function emitBody(): void
    {
        readfile($this->fileName);
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