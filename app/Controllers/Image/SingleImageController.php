<?php

namespace Controllers\Image;

use Exception\SqlException;
use Services\PhotoService;

class SingleImageController
{
    private PhotoService $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    /**
     * @param $params
     * @return array
     * @throws SqlException
     */
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