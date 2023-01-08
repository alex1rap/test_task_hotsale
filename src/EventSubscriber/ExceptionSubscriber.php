<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Exception\NotValidatedHttpException;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Throwable;

class ExceptionSubscriber implements EventSubscriberInterface
{

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

    /**
     * @param ExceptionEvent $event
     * @return void
     * @throws Exception
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $request = $event->getRequest();
        if (strpos($request->getHost(), 'admin') !== false) {
            return;
        }

        $e = $event->getThrowable();

        $data = $this->getExceptionResponseData($e);

        $event->setResponse(new JsonResponse($data, $data['code']));
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    /**
     * @throws Exception
     */
    private function getExceptionResponseData(Throwable $e): array
    {
        $error = [
            'code' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => JsonResponse::$statusTexts[JsonResponse::HTTP_INTERNAL_SERVER_ERROR],
        ];

        if ($e instanceof NotValidatedHttpException) {
            $errors = $e->getErrors();
            $error['code'] = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
            $error['errors'] = $errors;
            unset($error['message']);
            $this->logger->warning(json_encode($errors));
            return $error;
        }

        if ($e instanceof HttpException) {
            $error['code'] = $e->getStatusCode();
            $error['message'] = $e->getMessage();
            $this->logger->warning($error['message']);
        }

        if (getenv('APP_ENV') !== 'prod') {
            $error['message'] = $e->getMessage();
            $this->logger->warning($error['message']);
        }

        $this->logger->warning($error['message']);

        return $error;
    }
}
