<?php

namespace Controllers\Image;

use Request\Request;
use Response\Response;
use RuntimeException;
use Services\PhotoService;
use Validation\Validator;

class ImageCreateSubmitController
{

    private string $basePath;
    private Request $request;
    private PhotoService $photoService;
    private Validator $validator;

    public function __construct(string $basePath, Request $request, PhotoService $photoService, Validator $validator)
    {
        $this->basePath = $basePath;
        $this->request = $request;
        $this->photoService = $photoService;
        $this->validator = $validator;
    }

    public function submit(): Response
    {
        $targetDir = $this->basePath."/storage/";
        try {
            $title = $this->request->getParam("title");
            $file = $this->request->getFile("file");
            $violations = $this->validate($title, $file);
            if (count($violations) !== 0){
                return new Response(json_encode([
                    "success" => false,
                    "error" => $violations->get(0)->getMessage()
                ]), [], 400, "Bad request");
            }
            $targetFile = uniqid($targetDir, true);
            $file->moveTo($targetFile);
            $photo = $this->photoService->createImage($title, "/private/".basename($targetFile));
            return new Response(json_encode([
                "success" => true,
                "message" => "/image/". $photo->getId()
            ]), [], 201, "Created");
        } catch (RuntimeException $ex) {
            logMessage("ERROR", $ex->getMessage() );
            return new Response(json_encode([
                "success" => false,
                "error" => $ex->getMessage()
            ]), [], 500, "Internal server error");
        }
    }

    private function validate($title, $file)
    {
        return $this->validator->validate([
            "required|min:5|max:255" => $title,
            "required|image" => $file
        ]);
    }
}