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
use App\Utils\Position;
use DateTimeImmutable;

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
    public function start(ObjetDistantRepository $objetDistantRepository, EntityManagerInterface $em): Response
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
        $jeu->setDateCreation(new DateTimeImmutable());
        $em->persist($jeu);
        $em->flush();

        // On génère le point de départ, comme la première étape du parcour
        $parcour = Position::generate_random_parcour($objetDistant);

        $parcour->setIdJeu($jeu);
        $em->persist($parcour);
        $em->flush();

        // Fournir le point de départ à la vue
        $data = [
            "objet_distant" => $jeu->getIdObjetDistant(),
            "first_point" => $parcour
        ];

        return $this->json($data, 201);
    }
}