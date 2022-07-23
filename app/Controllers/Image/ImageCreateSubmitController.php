<?php

namespace Controllers\Image;

use Request\Request;
use Response\Redirect;
use RuntimeException;
use Services\PhotoService;
use Validation\Validator;

class ImageCreateSubmitController
{

    private $basePath;
    private Request $request;
    private PhotoService $photoService;
    private Validator $validator;

    public function __construct($basePath, Request $request, PhotoService $photoService, Validator $validator)
    {
        $this->basePath = $basePath;
        $this->request = $request;
        $this->photoService = $photoService;
        $this->validator = $validator;
    }

    public function submit()
    {
        $targetDir = $this->basePath."/storage/";
        try {
            $title = $this->request->getParam("title");
            $file = $this->request->getFile("file");
            $violations = $this->validate($title, $file);
            if (count($violations) !== 0){
                return Redirect::to("/image/add")
                    ->with("violations", $violations);
            }

            $targetFile = uniqid($targetDir, true); //$targetDir. basename($file->getName());
            $file->moveTo($targetFile);
            $photo = $this->photoService->createImage($title, "/private/".basename($targetFile));
            return Redirect::to("/image/add". $photo->getId());

        } catch (RuntimeException $ex) {
            logMessage("ERROR", $ex->getMessage() );
            return Redirect::to("/image/add");
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