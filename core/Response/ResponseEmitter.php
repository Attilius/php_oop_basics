<?php

namespace Response;

class ResponseEmitter
{
    /**
     * @param ResponseInterface $response
     * @return void
     */
    public function emit(ResponseInterface $response): void
    {
        $this->emitStatusLine($response->getStatusCode(), $response->getReasonPhrase());
        $this->emitHeaders($response->getHeaders());
        $response->emitBody();
    }

    private function emitStatusLine(int $statusCode, string $reasonPhrase): void
    {
        header(sprintf(
            "HTTP/1.1 %d%s",
            $statusCode,
            $reasonPhrase
        ), true, $statusCode);
    }

    private function emitHeaders(array $headers): void
    {
        foreach ($headers as $key => $value){
            header(sprintf("%s: %s", $key,$value));
        }
    }
}