<?php

namespace App\Service;

use App\Repository\ObjetProcheRepository;
use App\Service\ObjetHelper;
use Doctrine\Orm\QueryBuilder;

class ObjetProcheHelper extends ObjetHelper
{
    /**
     * @param ObjetProcheRepository $ObjetProcheRepository
     */
    public function __construct(ObjetProcheRepository $ObjetProcheRepository)
    {
        parent::__construct($ObjetProcheRepository);
    }

    public function applyResearch(array $properties): QueryBuilder
    {
        $queryBuilder = parent::applyResearch($properties);

        $filter = array_key_exists("filter", $properties) ? $properties['filter'] : "";

        // Parse par constellations
        if(!empty($filter)){
            $queryBuilder = $this->getRepository()->findByFilter($queryBuilder, $filter);
        }

        return $queryBuilder;
    }
}