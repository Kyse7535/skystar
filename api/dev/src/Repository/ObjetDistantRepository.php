<?php

namespace App\Repository;

use App\Entity\Constellation;
use App\Entity\ObjetDistant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use App\Repository\ObjetRepositoryInterface;

/**
 * @method ObjetDistant|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjetDistant|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjetDistant[]    findAll()
 * @method ObjetDistant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjetDistantRepository extends ServiceEntityRepository implements ObjetRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjetDistant::class);
    }

    public function getIdentifier(): string
    {
        $em = $this->getEntityManager();
        return $em->getMetaDataFactory()->getMetaDataFor(ObjetDistant::class)->getIdentifier()[0];
    }

    // Return a QueryBuilder
    public function findByAttributDataProvider(QueryBuilder $queryBuilder, int $ra, int $deca, int $magnitude, int $raRange, int $decaRange): QueryBuilder
    {
        $raMin = ($ra-($raRange/2));
        $raMax = ($ra+($raRange/2));
        $decaMin = ($deca-($decaRange/2));
        $decaMax = ($deca+($decaRange/2));

        $alias = $queryBuilder->getRootAlias();

        $queryBuilder
            ->andWhere($alias.".ra >= :raMin")
            ->andWhere($alias.".ra <= :raMax")
            ->andWhere($alias.".deca >= :decMin")
            ->andWhere($alias.".deca <= :decMax")
            ->andWhere($alias.".magnitude >= :magnitudeMin")
            ->andWhere($alias.".magnitude <= :magnitudeMax")
            ->setParameter("raMin", $raMin)
            ->setParameter("raMax", $raMax)
            ->setParameter("decMin", $decaMin)
            ->setParameter("decMax", $decaMax)
            ->setParameter("magnitudeMin", $magnitude - 1)
            ->setParameter("magnitudeMax", $magnitude + 1);

        return $queryBuilder;
    }

    // Return an Array
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

    public function findOneRandom(): ObjetDistant {
        $query = $this->createQueryBuilder("o")
            ->orderBy('RANDOM()')
            ->setMaxResults(1);

        return $query->getQuery()->getOneOrNullResult();
    }

    public function findByConstellations(QueryBuilder $queryBuilder, array $constellations): QueryBuilder
    {
        $alias = $queryBuilder->getRootAlias();
        $queryBuilder
            ->leftJoin($alias.'.idConstellation', 'idConstellation')
            ->andWhere($queryBuilder->expr()->in('idConstellation', $constellations));
        return $queryBuilder;

    }

    public function getResult(QueryBuilder $queryBuilder) {
        $query = $queryBuilder->getQuery();
        return $query->execute();
    }

}
