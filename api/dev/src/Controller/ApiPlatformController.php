<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiPlatformController extends AbstractController
{
    #[Route('/api/platform', name: 'api_platform')]
    public function index(): Response
    {
        return $this->render('api_platform/index.html.twig', [
            'controller_name' => 'ApiPlatformController',
        ]);
    }
}
