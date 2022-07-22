<?php

namespace Response;

interface ResponseInterface
{

    public function emitBody();
    public function getHeaders(): array;
    public function getStatusCode(): int;
    public function getReasonPhrase(): string;

}