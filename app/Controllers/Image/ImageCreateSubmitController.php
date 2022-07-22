<?php

namespace Controllers\Image;

use Request\Request;
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
            $violations = $this->validate($this->request);
            if (count($violations) !== 0){
                $this->request->getSession()->put("violations", $violations);
                return [
                    "redirect:/image/add",
                    []
                ];
            }
            switch ($file->getError()){
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException("No file sent.");
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException("Exceeded filesize limit.");
                default:
                    throw new RuntimeException("Unknown errors.");
            }
            $check = getimagesize($file->getTemporaryName());
            if ($check !== false){
                $targetFile = uniqid($targetDir, true); //$targetDir. basename($file->getName());
                $file->moveTo($targetFile);
                $photo = $this->photoService->createImage($title, "/private/".basename($targetFile));
                return [
                    "redirect:/image/". $photo->getId(),
                    []
                ];
            } else {
                throw new RuntimeException("File is not an image!");
            }
        } catch (RuntimeException $ex) {
            logMessage("ERROR", $ex->getMessage() );
            return [
                "redirect:/image/add",
                []
            ];
        }
    }

    private function validate(Request $request)
    {
        return $this->validator->validate([
            $request->getParam("title") => "required|min:5|max:255"
        ]);
    }
}