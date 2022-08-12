<?php

namespace Controllers;

class NotFoundController
{
    /**
     * @return array
     */
    function handle(): array
    {
        return [
            "404",
            [
                "title" => "The page you are looking for is not found"
            ]
        ];
    }
}