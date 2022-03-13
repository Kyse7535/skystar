<?php

namespace App\Controller;

use App\Entity\Jeu;
use App\Repository\JeuRepository;
use App\Repository\ObjetDistantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/jeu', name: 'api_jeu_')]
class JeuController extends AbstractController
{
    /**
     * Récupère les 10 meilleurs joueurs du classement
     */
    #[Route('/best_10', name: 'best_10', methods:['GET'])]
    public function best10(JeuRepository $jeuRepository): Response
    {
        $data = $jeuRepository->get10Best();
        return $this->json($data, 201);
    }

    /**
     * Créer une partie
     */
    #[Route('/start', name: 'start', methods:['POST'])]
    public function start(JeuRepository $jeuRepository, ObjetDistantRepository $objetDistantRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if(!$user)
            throw new UnauthorizedHttpException("Vous devez être connecter");
        
        // Trouver un objet proche random
        $objetDistant = $objetDistantRepository->findOneRandom();

        // Créer la partie
        $jeu = new Jeu();
        $jeu->setIdObjetDistant($objetDistant);
        $jeu->setPseudo($user->getUserIdentifier());
        $jeu->setTrouver(false);
        $em->persist($jeu);
        $em->flush();

        // Générer des valeurs de RA et DECA
        $randomRa = 0;
        $randomDeca = 0;

        // On génère le point de départ, comme la première étape du parcour
        $parcour = [
            "magnitude" => floor($objetDistant->getMagnitude()),
            "ra" => $randomRa,
            "deca" => $randomDeca
        ];

        // Fournir le point de départ à la vue
        $data = [
            "jeu" => $jeu->getIdJeu(),
            "joueur" => $jeu->getPseudo(),
            "point" => $parcour
        ];

        return $this->json($data, 201);
    }
}