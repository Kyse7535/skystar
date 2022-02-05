<?php

namespace App\Controller;

use App\Entity\ObjetDistant;
use App\Repository\ConstellationRepository;
use App\Repository\ObjetDistantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiPlatformController extends AbstractController
{
    #[Route('/api/platform', name: 'api_platform', methods:['GET'])]
    public function index(ObjetDistantRepository $repository, EntityManagerInterface $em): Response
    {
        //$id = 1;
        //$objetDistant = $em->getRepository(ObjetDistant::class)->findByObjetDistant($id);
        $objetDistant = $em->getRepository(ObjetDistant::class)->findByAttribut();

        return $this->json($objetDistant, 200, [], ['groups' => 'read:collection']);
    }
}
