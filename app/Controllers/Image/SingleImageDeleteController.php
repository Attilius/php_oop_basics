<?php

namespace Controllers\Image;

use Services\PhotoService;

class SingleImageDeleteController
{
    private PhotoService $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    function delete($params): array
    {
        $id = $params["id"];
        $this->photoService->deleteImage($id);
        return[
            "redirect:/",
            []
        ];
    }
}