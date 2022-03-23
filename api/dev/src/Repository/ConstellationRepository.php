<?php

namespace App\Repository;

use App\Entity\Constellation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Constellation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Constellation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Constellation[]    findAll()
 * @method Constellation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConstellationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Constellation::class);
    }

    public function findFithFirst()
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.idConstellation <= 16');
        $query = $qb->getQuery();

        return $query->execute();
    }

    public function findAll()
    {
        $qb = $this->createQueryBuilder('p');
        $query = $qb->getQuery();

        return $query->execute();
    }

    public function findOneByName(string $latinName)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.latinName = :latinName ')
            ->setParameter('latinName', "%$latinName%")
            ->getQuery()
            ->execute();
        return $qb;
    }
}
