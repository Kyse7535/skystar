<?php

namespace App\Repository;

use App\Entity\Jeu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Jeu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jeu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jeu[]    findAll()
 * @method Jeu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JeuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jeu::class);
    }

    public function get10Best(): array {
        $query = $this
            ->createQueryBuilder("j")
            ->where(
                "j.trouver = 1"
            )
            ->orderBy("j.duree", "ASC")
            ->setMaxResults(10)
            ->getQuery();

        return $query->execute();
    }

}