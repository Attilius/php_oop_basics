<?php

namespace Controllers\Image;

use Exception\SqlException;
use Services\PhotoService;

class SingleImageEditController
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
    function edit($params): array
    {
        $title = $_POST["title"];
        $id = $params["id"];
        $this->photoService->updateImage($id, $title);
        return[
            "redirect:/image/$id",
            []
        ];
    }
}