<?php

namespace App\Service;
use App\Repository\ObjetDistantRepository;
use Doctrine\Orm\QueryBuilder;
use App\Service\ObjetHelper;

class ObjetDistantHelper extends ObjetHelper
{
    /**
     * @param ObjetDistantRepository $ObjetDistantRepository
     */
    public function __construct(ObjetDistantRepository $ObjetDistantRepository)
    {
        parent::__construct($ObjetDistantRepository);
    }

    public function applyResearch(array $properties): QueryBuilder
    {
        return parent::applyResearch($properties);
    }
}