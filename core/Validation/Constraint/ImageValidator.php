<?php

namespace Validation\Constraint;

use FileSystem\UploadedFile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ImageValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Image){
            throw new UnexpectedTypeException($constraint, Image::class);
        }
        if ($value === null || $value === ''){
            return;
        }
        if (!$value instanceof UploadedFile){
            throw new UnexpectedTypeException($value, UploadedFile::class);
        }
        switch ($value->getError()){
            case UPLOAD_ERR_OK:
                $check = getimagesize($value->getTemporaryName());
                if (!$check){
                    $this->context->buildViolation("Not an image.")->addViolation();
                }
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->context->buildViolation("No file sent.")->addViolation();
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $this->context->buildViolation("Exceeded filesize limit.")->addViolation();
                break;
            default:
                $this->context->buildViolation("Error during file upload.")->addViolation();
                break;
        }
    }
}