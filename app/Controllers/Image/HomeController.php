<?php

namespace Controllers\Image;

use Services\PhotoService;

class HomeController
{
    private PhotoService $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    function handle()
    {
        $size = $_GET['size'] ?? 10; // (??) if $_GET['size] = null -> default value = 10
        $page = $_GET['page'] ?? 1;
        $total = $this->photoService->getTotal();
        $offset = ($page - 1) * $size;
        $content = $this->photoService->getPhotosPaginated($size, $offset);
        $possiblePageSizes = [10,20,30,40,50];

        return [
            "home",
            [
                "title" => "Home",
                "content" => $content,
                "total" => $total,
                "size" => $size,
                "page" => $page,
                "offset" => $offset,
                "possiblePageSizes" => $possiblePageSizes
            ]
        ];
    }
}