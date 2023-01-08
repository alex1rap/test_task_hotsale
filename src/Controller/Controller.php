<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Controller implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected static $serializeGroups = ['safe'];

    protected function buildViolation(string $message, string $property): ConstraintViolation
    {
        return new ConstraintViolation($message, null, [], null, $property, null);
    }

    protected function getSerializer(): SerializerInterface
    {
        return $this->container->get('serializer');
    }

    protected function getValidator(): ValidatorInterface
    {
        return $this->container->get('validator');
    }
}
