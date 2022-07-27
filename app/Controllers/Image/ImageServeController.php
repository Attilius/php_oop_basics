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

    /**
     * @param array $params
     * @return BinaryFileResponse
     */
    public function show(array $params): BinaryFileResponse
    {
        return new BinaryFileResponse($this->basePath."/storage/".$params["id"]);
    }
}