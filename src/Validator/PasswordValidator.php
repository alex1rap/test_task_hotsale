<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class PasswordValidator extends ConstraintValidator
{

    /**
     * @param $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof Password) {
            throw new UnexpectedValueException($value, Password::class);
        }

        if (!(
            preg_match("/[0-9]/", $value) &&
            preg_match("/[a-z]/", $value) &&
            preg_match("/[A-Z]/", $value) &&
            preg_match("~[!\"\$%&'()*+,./:;<=>?@[\]^_`{|}-]~", $value)
        )) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
