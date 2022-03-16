<?php

namespace App\Controller;

use App\Entity\ObjetDistant;
use App\Repository\ConstellationRepository;
use App\Repository\ObjetDistantRepository;
use App\Repository\ObjetProcheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Utils\Position;

class ApiPlatformController extends AbstractController
{
    #[Route('/api/map/objet_distants', name: 'api_map_objet_distants', methods:['GET'])]
    public function objet_distants(Request $request, ObjetDistantRepository $repository, EntityManagerInterface $em): Response
    {
        $ra = $request->query->get('ra');
        $deca = $request->query->get('deca');
        $magnitude = $request->query->get('magnitude');

        if(!is_numeric($ra) 
            || !is_numeric($deca)
            || !is_numeric($magnitude))
            return $this->json(["message" => "RA, DECA et Magnitude doivent être renseigner."], 401, [], ['groups' => 'read:collection']);

        $raRange = Position::get_ra_range($request->query->get('raRange'));
        $decaRange = Position::get_deca_range($request->query->get('decaRange'));     

        $objetDistants = $repository->findByAttribut((int) $ra, (int) $deca, (int) $magnitude, $raRange, $decaRange);

        return $this->json($objetDistants, 200, [], ['groups' => 'read:collection']);
    }

    #[Route('/api/map/objet_proches', name: 'api_map_objet_proches', methods:['GET'])]
    public function objet_proches(Request $request, ObjetProcheRepository $repository, EntityManagerInterface $em): Response
    {
        $ra = $request->query->get('ra');
        $deca = $request->query->get('deca');
        $magnitude = $request->query->get('magnitude');

        if(!is_numeric($ra) 
            || !is_numeric($deca)
            || !is_numeric($magnitude))
            return $this->json(["message" => "RA, DECA et Magnitude doivent être renseigner."], 401, [], ['groups' => 'read:collection']);

        $raRange = Position::get_ra_range($request->query->get('raRange'));
        $decaRange = Position::get_deca_range($request->query->get('decaRange'));                 

        $objetProches = $repository->findByAttribut((int) $ra, (int) $deca, (int) $magnitude, $raRange, $decaRange);

        return $this->json($objetProches, 200, [], ['groups' => 'read:collection']);
    }
}
