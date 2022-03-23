<?php

namespace App\DataProvider;

use App\Entity\ObjetProche;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

use ApiPlatform\Core\DataProvider\Pagination;
use App\Repository\ObjetProcheRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Doctrine\ORM\QueryBuilder;
use App\Service\ObjetProcheHelper;

final class ObjetprocheCollectionDataProvider
    implements ContextAwareCollectionDataProviderInterface,
    RestrictedDataProviderInterface
{
    private ObjetProcheRepository $ObjetProcheRepository;
    private ObjetProcheHelper $objetHelper;
    private $pagination;

    /**
     * @param ObjetProcheRepository $ObjetProcheRepository
     * @param ObjetProcheHelper $objetHelper
     */
    public function __construct(ObjetProcheRepository $ObjetProcheRepository, ObjetProcheHelper $objetHelper, Pagination $pagination)
    {
        $this->objetHelper = $objetHelper;
        $this->ObjetProcheRepository = $ObjetProcheRepository;
        $this->pagination = $pagination;
    }


    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return ObjetProche::class === $resourceClass && ('get' === $operationName);
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        $query = $this->ObjetProcheRepository->findByAttribut($context);

        if(!empty($context["constelllation"]) && is_array($context["constellation"]) &&
            count($context["constellation"]) > 0)
        {
            $query = $this->ObjetProcheRepository->findByConstellations($query, $context["constellation"]);
        }
        list($currentPage, $offset, $resultMax) = $this->pagination->getPagination($resourceClass, $operationName, $context);


        return new ObjetProchePaginator($this->objetHelper, $currentPage, $resultMax, $context);
        //return $this->ObjetProcheRepository->getResult($query);
    }
}