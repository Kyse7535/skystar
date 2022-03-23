<?php

namespace App\Repository;

use App\Entity\Constellation;
use App\Entity\ObjetProche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;


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

    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */
    public function findByObjetProche(int $const) : array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT o
            FROM App\Entity\ObjetProche o
            WHERE o.idObjetProche =:idObjetProche')
            ->setParameter('idObjetProche', $const);

        return $query->getResult();

    }

    public function findByAttribut(array $context): QueryBuilder
    {
        if (empty($context['ra']) || empty($context["dec"]) || empty($context["magnitude"]))
        {

            return $this->createQueryBuilder('p');
        }
        $qb = $this->createQueryBuilder('p')
            ->andWhere("p.ra >= :raMin")
            ->andWhere("p.ra <= :raMax")
            ->andWhere("p.deca >= :decMin")
            ->andWhere("p.deca <= :decMax")
            ->andWhere("p.magnitude >= :magnitudeMin")
            ->andWhere("p.magnitude <= :magnitudeMax")
            ->setParameter("raMin", intval($context["ra"]) - intval($context["raRange"]) / 2)
            ->setParameter("raMax", intval($context["ra"]) + intval($context["raRange"]) / 2)
            ->setParameter("decMin", intval($context["dec"]) - intval($context["decaRange"]) / 2)
            ->setParameter("decMax", intval($context["dec"]) + intval($context["decaRange"]) / 2)
            ->setParameter("magnitudeMin", intval($context["magnitude"]) - 1)
            ->setParameter("magnitudeMax", intval($context["magnitude"]) + 1);

        return $qb;
    }

    public function findByConstellations(QueryBuilder $queryBuilder, array $constellations): QueryBuilder
    {
        $queryBuilder
            ->leftJoin('o.idConstellation', 'idConstellation')
            ->andWhere($queryBuilder->expr()->in('idConstellation', $constellations));
        return $queryBuilder;

    }

    public function getResult(QueryBuilder $queryBuilder) {
        $query = $queryBuilder->getQuery();
        return $query->execute();
    }

}
