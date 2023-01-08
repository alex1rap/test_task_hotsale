<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends JsonController
{

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/registration")
     */
    public function register(Request $request): Response
    {
        return $this->respond([]);
    }

}
