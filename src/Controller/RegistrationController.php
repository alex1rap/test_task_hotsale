<?php

namespace App\Controller;

use App\Dataset\RegistrationDataset;
use App\Service\UsersListService;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends JsonController
{

    /**
     * @param Request $request
     * @param UsersListService $service
     * @return Response
     *
     * @Route("/registration", name="registration", methods={"POST"})
     */
    public function register(Request $request, UsersListService $service): Response
    {
        $registration = $this->deserializeAndValidate($request->getContent(), RegistrationDataset::class);
        $this->logger->log('debug', sprintf(
            'User %s was successfully validated.', $this->serialize($registration)
        ));
        if ($service->find($registration->email)) {
            throw new InvalidArgumentException(sprintf(
                'User with email "%s" already registered', $registration->email
            ));
        }
        return $this->respond($registration);
    }

}
