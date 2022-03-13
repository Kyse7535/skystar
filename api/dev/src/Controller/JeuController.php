<?php

namespace App\Controller;

use App\Entity\Jeu;
use App\Entity\Parcours;
use App\Repository\JeuRepository;
use App\Repository\ObjetDistantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Utils\Position;
use DateInterval;
use DateTime;
use DateTimeImmutable;

#[Route('/api/jeu', name: 'api_jeu_')]
class JeuController extends AbstractController
{
    /**
     * Ajouter un parcour
     */
    #[Route('/{id}/add_parcour', name: 'add_parcour', methods:['POST'])]
    public function add_parcour(Jeu $jeu, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if(!$user || str_replace(" ", "", $jeu->getPseudo()) != str_replace(" ", "", $user->getUserIdentifier()))
            throw new UnauthorizedHttpException("Vous devez être connecter");

        $json_request = json_decode(
            $request->getContent(),
            true
        );
        $ra = key_exists("ra", $json_request) ? $json_request["ra"] : null;
        $deca = key_exists("deca", $json_request) ? $json_request["deca"] : null;
        $magnitude = key_exists("magnitude", $json_request) ? $json_request["magnitude"] : null;

        if(!is_numeric($ra) 
            || !is_numeric($deca)
            || !is_numeric($magnitude))
            return $this->json(["message" => "RA, DECA et Magnitude doivent être renseigner."], 401, [], ['groups' => 'read:collection']);
    

        $parcour = new Parcours();
        $parcour->setIdJeu($jeu);
        $parcour->setRa($ra);
        $parcour->setDeca($deca);
        $parcour->setMagnitude($magnitude);

        $em->persist($parcour);
        $em->flush();
        
        return $this->json($parcour, 201);
    }

    /**
     * Proposer une solution
     * La partie se termine lorsque le joueur a trouver l'objet rechercher
     */
    #[Route('/{id}/trouver', name: 'trouver', methods:['POST'])]
    public function trouver(Jeu $jeu, Request $request, ObjetDistantRepository $objetDistantRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if(!$user || str_replace(" ", "", $jeu->getPseudo()) != str_replace(" ", "", $user->getUserIdentifier()))
            throw new UnauthorizedHttpException("Vous devez être connecter");

        $json_request = json_decode(
            $request->getContent(),
            true
        );

        if(!$json_request)
            return $this->json(["message" => "RA et DECA doivent être renseigner."], 401, [], ['groups' => 'read:collection']);

        $ra = key_exists("ra", $json_request) ? $json_request["ra"] : null;
        $deca = key_exists("deca", $json_request) ? $json_request["deca"] : null;
        
        if(!is_numeric($ra) 
            || !is_numeric($deca))
            return $this->json(["message" => "RA et DECA doivent être renseigner."], 401, [], ['groups' => 'read:collection']);
    
        // Si l'objet n'est pas trouvé
        if(!Position::check_is_object_find($jeu->getIdObjetDistant(), $ra, $deca))
            return $this->json([
                "message" => "Vous vous êtes tromper ! Réessayer ultérieurement :p",
                "response" => "INVALID"
            ], 201);

        // Si l'objet a été trouvé
        $jeu->setTrouver(1);
        $jeu->setDuree(new DateTimeImmutable());

        // Calcul des points par le nombre de seconde pour trouver l'objet
        $jeu->setPoint(
            strtotime($jeu->getDuree()->format("c"))-
            strtotime($jeu->getDateCreation()->format("c")));

        $em->persist($jeu);
        $em->flush();

        return $this->json([
            "jeu" => $jeu,
            "message" => "CONGRATS", 
            "response" => "VALID"
        ], 201);
    }

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

        $em->getConnection()->beginTransaction(); // suspend auto-commit
        try {
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

            $em->getConnection()->commit();

            // Fournir le point de départ à la vue
            $data = [
                "id_jeu" => $jeu->getIdJeu(),
                "objet_distant" => $jeu->getIdObjetDistant(),
                "first_point" => $parcour
            ];

            return $this->json($data, 201);
        // On push les deux data dans la bdd simultanéments, pour éviter qu'une erreur survienne entre les deux.
        // Par exemple, un jeu est push, et une erreur est générer dans la création du parcour, et on a un jeu sans parcour initial.
        // Pour éviter ça, on effectue nos calcul et on push tout en même temps.
        } catch (\Exception $e) {
            $em->getConnection()->rollBack();
            throw $e;
        }
    }
}