<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @\Attribute()
 * @Annotation
 */
class Password extends Constraint
{
    public $message = 'The password must contain between 8 and 32 characters, including upper and lower case letters, numbers and special characters.';
}
