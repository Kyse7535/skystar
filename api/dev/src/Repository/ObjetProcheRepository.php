<?php

namespace App\Repository;

use App\Entity\ObjetProche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ObjetProche|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjetProche|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjetProche[]    findAll()
 * @method ObjetProche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjetProcheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjetProche::class);
    }

    public function findByAttribut(int $ra, int $deca, int $magnitude, int $raRange, int $decaRange) : array
    {
        $entityManager = $this->getEntityManager();

        $raMin = ($ra-($raRange/2));
        $raMax = ($ra+($raRange/2));
        $decaMin = ($deca-($decaRange/2));
        $decaMax = ($deca+($decaRange/2));
        $query = $entityManager->createQuery(
            'SELECT p    
              FROM App\Entity\ObjetProche p
                WHERE p.ra > '.$raMin.' AND p.ra < '.$raMax.'
                    AND  p.deca > '.$decaMin.'
                    AND  p.deca < '.$decaMax.'
                    AND p.magnitude > '.$magnitude.' AND p.magnitude < '.($magnitude + 7)) ;

        return $query->getResult();
    }
}