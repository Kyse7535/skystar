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

    public function findByAttribut($ra, $dec, $magnitude) : array
    {
        if (empty($ra) || empty($dec) || empty($magnitude))
        {
            return array();
        }

        $qb = $this->createQueryBuilder('p')
        ->where("p.ra >= :raMin")
        ->andWhere("p.ra <= :raMax")
        ->andWhere("p.deca >= :decMin")
        ->andWhere("p.deca <= :decMax")
        ->andWhere("p.magnitude >= :magnitudeMin")
        ->andWhere("p.magnitude <= :magnitudeMax")
        ->setParameter("raMin", $ra - 1)
        ->setParameter("raMax", $ra + 1)
        ->setParameter("decMin", $dec - 1)
        ->setParameter("decMax", $dec + 1)
        ->setParameter("magnitudeMin", $magnitude - 1)
        ->setParameter("magnitudeMax", $magnitude + 1);
        $query = $qb->getQuery();

        return $query->execute();

    }

    public function findFithFirst()
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.idObjetDistant <= :var')
            ->setParameter('var', 5);
        $query = $qb->getQuery();

        return $query->execute();
    }

    public function findByConstellations(array $constellations)
    {
        $qb = $this->createQueryBuilder('o')
                ->leftJoin('o.idConstellation', 'idConstellation')
                ->andWhere($queryBuilder->expr()->in('idConstellation', $constellations));      
                $query = $qb->getQuery();

                return $query->execute();
    }

}
