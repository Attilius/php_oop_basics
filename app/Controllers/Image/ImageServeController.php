<?php

namespace Controllers\Image;

use Response\BinaryFileResponse;

class ImageServeController
{
    private string $basePath;

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    public function show(array $params)
    {
        return new BinaryFileResponse($this->basePath."/storage/".$params["id"]);
    }
}