<?php

namespace Controllers;

use Services\PhotoService;

class SingleImageController
{
    private PhotoService $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    function display($params){
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