<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class Controller implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected static $serializeGroups = ['safe'];

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

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

    protected function getTranslator(): TranslatorInterface
    {
        return $this->container->get('translator');
    }
}
