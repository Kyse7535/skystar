<?php

namespace App\Repository;

use App\Entity\Parcours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Parcours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parcours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parcours[]    findAll()
 * @method Parcours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParcoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parcours::class);
    }


}