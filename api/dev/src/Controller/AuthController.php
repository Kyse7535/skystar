<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use JWTProtocols;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/auth', name: 'api_auth_')]
class AuthController extends AbstractController
{
    #[Route('/login', name: 'login', methods:['POST'])]
    public function login(Request $request, EntityManagerInterface $em): Response
    {
        $json_request = json_decode(
            $request->getContent(),
            true
        );

        if(!key_exists("pseudo", $json_request))
            return $this->json(["message" => "Le pseudo doit être renseigner"], 401);

        $pseudo = $json_request["pseudo"];

        if(empty($pseudo))
            return $this->json(["message" => "Le pseudo doit être renseigner"], 401);

        $jwt = new JWTProtocols();
        $data = [
            "message" => "success",
            "key" => $jwt->sign($pseudo)
        ];

        return $this->json($data, 200, [], ['groups' => 'read:collection']);
    }
}
