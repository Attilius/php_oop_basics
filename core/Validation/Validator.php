<?php

namespace Validation;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use Validation\Constraint\Image;

class Validator
{
    public function validate(array $valueConstraintMap): ConstraintViolationList
    {
        $violations = new ConstraintViolationList();
        foreach ($valueConstraintMap as $constraints => $value){
            $newViolations = Validation::createValidator()
            ->validate($value, $this->instantiateConstraints($constraints));
            $violations->addAll($newViolations);
        }
        return $violations;
    }

    /**
     * @return Constraint[]
     */
    private function instantiateConstraints(string $constraints): array
    {
        $constraintsInstances = [];
        $identifiers = explode("|", $constraints);
        foreach ($identifiers as $identifier){
            $constraintsInstances[] = $this->createConstraint($identifier);
        }
        return $constraintsInstances;
    }

    private function createConstraint(string $identifier): Constraint
    {
        list($constraint, $param) = array_pad(explode(":", $identifier), 2, null);
        switch ($constraint){
            case "required" :
                return new NotBlank();
            case "min" :
                return new Length(["min" => $param]);
            case "max" :
                return new Length(["max" => $param]);
            case "image":
                return new Image();
            default:
                throw new \InvalidArgumentException("The constraint string ${$constraint} is not available!");
        }
    }
}