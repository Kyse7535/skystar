<?php

namespace App\Service;
use App\Entity\ObjetDistant;
use App\Repository\ObjetDistantRepository;
use App\Repository\ObjetProcheRepository;

class ObjetDistantHelper
{
    private ObjetDistantRepository $ObjetDistantRepository;

    /**
     * @param ObjetDistantRepository $ObjetDistantRepository
     */
    public function __construct(ObjetDistantRepository $ObjetDistantRepository)
    {
        $this->ObjetDistantRepository = $ObjetDistantRepository;
    }

    public function fetchMany(int $limit = null, int $offset = null, array $criteria = [])
    {
        $query = $this->ObjetDistantRepository->findByAttribut($criteria)
            ->setFirstResult( $offset )
            ->setMaxResults( $limit );
        return $this->ObjetDistantRepository->getResult($query);
    }

    public function count(array $context):int
    {
        $result = $this->ObjetDistantRepository->findByAttribut($context)
            ->getQuery()->execute();
        return count($result);
    }
}