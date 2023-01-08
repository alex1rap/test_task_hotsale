<?php

namespace App\Exception;

use Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class NotValidatedHttpException extends UnprocessableEntityHttpException
{
    /**
     * @var array
     */
    private $errors;

    /**
     * @param ConstraintViolationListInterface|null $errors
     * @param string|null $message
     * @param Exception|null $previous
     * @param int $code
     * @param array $headers
     */
    public function __construct(ConstraintViolationListInterface $errors = null, string $message = null, Exception $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct($message, $previous, $code, $headers);

        if ($errors) {
            $this->setErrors($errors);
        }
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param ConstraintViolationListInterface $errors
     * @return $this
     */
    protected function setErrors(ConstraintViolationListInterface $errors): self
    {
        foreach ($errors as $error) {
            $this->errors[$error->getPropertyPath()] = $error->getMessage();
        }

        return $this;
    }
}
