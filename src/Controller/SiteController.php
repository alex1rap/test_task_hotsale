<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{

    /**
     * @return Response
     *
     * @Route("/", name="site_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('Views/registration.html.twig');
    }
}
