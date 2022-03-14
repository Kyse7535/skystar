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

class ApiPlatformController extends AbstractController
{
    private function get_ra_range($raRange) {
        if(empty($raRange) || !is_numeric($raRange)) {
            $raRange = $this->getParameter("RA_DEFAULT_RANGE");
        }
        else {
            if($raRange > $this->getParameter("RA_MAX_RANGE")) {
                $raRange = $this->getParameter("RA_MAX_RANGE");
            }
            if($raRange < $this->getParameter("RA_MIN_RANGE")) {
                $raRange = $this->getParameter("RA_MIN_RANGE");
            }
        }

        return $raRange;
    }

    private function get_deca_range($decaRange) {
        if(empty($decaRange) || is_numeric($decaRange)) {
            $decaRange = $this->getParameter("DECA_DEFAULT_RANGE");
        }
        else {
            if($decaRange > $this->getParameter("DECA_MAX_RANGE")) {
                $decaRange = $this->getParameter("DECA_MAX_RANGE");
            }
            if($decaRange < $this->getParameter("DECA_MIN_RANGE")) {
                $decaRange = $this->getParameter("DECA_MIN_RANGE");
            }
        } 

        return $decaRange;
    }

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

        $raRange = $this->get_ra_range($request->query->get('raRange'));
        $decaRange = $this->get_deca_range($request->query->get('decaRange'));     

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

        $raRange = $this->get_ra_range($request->query->get('raRange'));
        $decaRange = $this->get_deca_range($request->query->get('decaRange'));                 

        $objetProches = $repository->findByAttribut((int) $ra, (int) $deca, (int) $magnitude, $raRange, $decaRange);

        return $this->json($objetProches, 200, [], ['groups' => 'read:collection']);
    }
}
