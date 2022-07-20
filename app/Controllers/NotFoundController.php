<?php

namespace Controllers;

class NotFoundController
{
    function handle()
    {
        return [
            "404",
            [
                "title" => "The page you are looking for is not found."
            ]
        ];
    }
}