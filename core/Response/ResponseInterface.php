<?php

namespace Response;

interface ResponseInterface
{
    public function emitBody(): void;
    public function getHeaders(): array;
    public function getStatusCode(): int;
    public function getReasonPhrase(): string;
}