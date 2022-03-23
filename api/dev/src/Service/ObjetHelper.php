<?php 

namespace App\Service;
use Doctrine\Orm\QueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ObjetHelper
{
    private ServiceEntityRepository $repository;

    public function __construct(ServiceEntityRepository $serviceEntityRepository)
    {
        $this->repository = $serviceEntityRepository;
    }

    public function getRepository(): ServiceEntityRepository
    {
        return $this->repository;
    }

    public function applyResearch(array $properties): QueryBuilder
    {
        $queryBuilder = $this->repository->createQueryBuilder("p");

        // Initialisation variable
        $ra = array_key_exists("ra", $properties) ? $properties['ra'] : null;
        $dec = array_key_exists("dec", $properties) ? $properties['dec'] : null;
        $magnitude = array_key_exists("magnitude", $properties) ? $properties['magnitude'] : null;
        $constellations = array_key_exists("constellation", $properties) ? $properties['constellation'] : null;

        // Parse par constellations
        if($constellations && is_array($constellations) && count($constellations) > 0){
            $queryBuilder = $this->repository->findByConstellations($queryBuilder, $constellations);
        }

        // Parse par RA - DEC et Magnitude
        if(is_numeric($ra) && is_numeric($dec) && is_numeric($magnitude)) {
            $queryBuilder = $this->repository->findByAttributDataProvider(
                $queryBuilder, $ra, $dec, $magnitude, 2, 2);
        }
        
        return $queryBuilder;
    }

    public function fetchMany(int $limit = null, int $offset = null, array $criteria = [])
    {
        $query = $this->applyResearch($criteria)
            ->setFirstResult($offset)
            ->setMaxResults($limit);
        return $this->getRepository()->getResult($query);
    }

    public function count(array $context):int
    {
        $query = $this->applyResearch($context);
        $identifier = $this->repository->getIdentifier();
        $alias = $query->getRootAlias();

        if(!empty($alias))
            $query
                ->select("DISTINCT count(".$alias.".".$identifier.")");
        else
            $query
                ->select("DISTINCT count(".$identifier.")");

        return $query
            ->getQuery()->getSingleScalarResult();
    }
}