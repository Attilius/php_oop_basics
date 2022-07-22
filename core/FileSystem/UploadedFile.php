<?php

namespace FileSystem;

class UploadedFile implements FileInterface
{
    private string $name;
    private string $temporaryName;
    private string $error;

    public function __construct(string $name, string $temporaryName, string $error)
    {
        $this->name = $name;
        $this->temporaryName = $temporaryName;
        $this->error = $error;
    }

    public function moveTo($target): LocalFile
    {
        move_uploaded_file($this->getTemporaryName(), $target);
        return new LocalFile($target);
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTemporaryName(): string
    {
        return $this->temporaryName;
    }
}