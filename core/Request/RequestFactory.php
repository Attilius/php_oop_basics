<?php

namespace Request;

use Exception\ServiceNotFoundException;
use FileSystem\UploadedFile;
use ServiceContainer;

class RequestFactory
{
    /**
     * @param ServiceContainer $container
     * @return Request
     * @throws ServiceNotFoundException
     */
    public static function createFromGlobals(ServiceContainer $container): Request
    {
        $files = [];
        foreach ($_FILES as $name => $file){
            $files[$name] = new UploadedFile($file["name"], $file["tmp_name"], $file["error"]);
        }
        return new Request($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"], $container->get("session"),
            file_get_contents("php://input"), getallheaders(), $_COOKIE, array_merge($_GET, $_POST), $files);
    }
}