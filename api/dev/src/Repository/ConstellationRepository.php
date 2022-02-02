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


}
