<?php

namespace Controllers\Image;

use Response\BinaryFileResponse;

class ImageServeController
{
    private string $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function show($params)
    {
        return new BinaryFileResponse($this->basePath."/storage/".$params["id"]);
    }
}