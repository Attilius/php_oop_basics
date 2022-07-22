<?php

namespace FileSystem;

class LocalFile implements FileInterface
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function moveTo($target): void
    {
        rename($this->name, $target);
    }
}