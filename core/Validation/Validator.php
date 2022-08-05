<?php

namespace Validation;

use InvalidArgumentException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use Validation\Constraint\Image;

class Validator
{
    /**
     * @param array $valueConstraintMap
     * @return ConstraintViolationList
     */
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

    /**
     * @param string $identifier
     * @return Constraint
     */
    private function createConstraint(string $identifier): Constraint
    {
        list($constraint, $param) = array_pad(explode(":", $identifier), 2, null);
        return match ($constraint) {
            "required" => new NotBlank(),
            "min" => new Length(["min" => $param]),
            "max" => new Length(["max" => $param]),
            "image" => new Image(),
            default => throw new InvalidArgumentException("The constraint string ${$constraint} is not available!"),
        };
    }
}