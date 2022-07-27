<?php

namespace Controllers\Image;

use Services\PhotoService;

class SingleImageController
{
    private PhotoService $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    function display($params): array
    {
        $image = $this->photoService->getImageById($params['id']);
        return[
            "single",
            [
                "title" => $image->getTitle(),
                "image" => $image
            ]
        ];
    }
}