<?php

namespace Controllers;

use Services\PhotoService;

class SingleImageDeleteController
{
    private PhotoService $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    function delete($params){
        $id = $params["id"];
        $this->photoService->deleteImage($id);
        return[
            "redirect:/",
            []
        ];
    }
}