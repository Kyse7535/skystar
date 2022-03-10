<?php

namespace App\Repository;

use App\Entity\ObjetDistant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method ObjetDistant|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjetDistant|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjetDistant[]    findAll()
 * @method ObjetDistant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjetDistantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjetDistant::class);
    }

    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */
    public function findByObjetDistant(int $const) : array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT o
            FROM App\Entity\ObjetDistant o
            WHERE o.idObjetDistant =:idObjetDistant')
            ->setParameter('idObjetDistant', $const);

        return $query->getResult();

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
              FROM App\Entity\ObjetDistant p
                WHERE p.ra > '.$raMin.' AND p.ra < '.$raMax.'
                    AND  p.deca > '.$decaMin.'
                    AND  p.deca < '.$decaMax.'
                    AND p.magnitude > '.$magnitude.' AND p.magnitude < '.($magnitude + 7)) ;

        return $query->getResult();
    }

}
