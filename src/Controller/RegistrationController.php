<?php

namespace App\Controller;

use App\Dataset\RegistrationDataset;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends JsonController
{

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/registration", name="registration", methods={"POST"})
     */
    public function register(Request $request): Response
    {
        $registration = $this->deserializeAndValidate($request->getContent(), RegistrationDataset::class);
        $this->logger->log('debug', sprintf(
            'User %s was successfully validated.',
            $this->serialize($registration)
        ));
        return $this->respond($registration);
    }

}
