<?php

namespace FileSystem;

class LocalFile implements FileInterface
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param $target
     * @return void
     */
    public function moveTo($target): void
    {
        rename($this->name, $target);
    }
}