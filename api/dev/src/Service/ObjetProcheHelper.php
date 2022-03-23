<?php

namespace App\Service;

use App\Repository\ObjetProcheRepository;

class ObjetProcheHelper

{
    private ObjetProcheRepository $objetProcheRepository;

    /**
     * @param ObjetProcheRepository $objetProcheRepository
     */
    public function __construct(ObjetProcheRepository $objetProcheRepository)
    {
        $this->objetProcheRepository = $objetProcheRepository;
    }

    public function fetchMany(int $limit = null, int $offset = null, array $criteria = [])
    {
        $query = $this->objetProcheRepository->findByAttribut($criteria)
            ->setFirstResult( $offset )
            ->setMaxResults( $limit );
        return $this->objetProcheRepository->getResult($query);
    }

    public function count(array $context):int
    {
        $result = $this->objetProcheRepository->findByAttribut($context)
            ->getQuery()->execute();
        return count($result);
    }
}