<?php

namespace Controllers\Image;

use Exception\SqlException;
use Services\PhotoService;

class SingleImageDeleteController
{
    private PhotoService $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    /**
     * @param array $params
     * @return array
     * @throws SqlException
     */
    function delete(array $params): array
    {
        $id = $params["id"];
        $this->photoService->deleteImage($id);
        return[
            "redirect:/",
            []
        ];
    }
}