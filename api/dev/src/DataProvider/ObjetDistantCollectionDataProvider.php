<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Entity\ObjetDistant;
use App\Filter\ObjetFilter;
use ApiPlatform\Core\DataProvider\Pagination;
use App\Repository\ObjetDistantRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Doctrine\ORM\QueryBuilder;
use App\Service\ObjetDistantHelper;

final class ObjetDistantCollectionDataProvider implements ContextAwareCollectionDataProviderInterface,
RestrictedDataProviderInterface
{
    private ObjetDistantRepository $objetDistantRepository;
    private ObjetDistantHelper $objetHelper;
    private $pagination;

    /**
     * @param ObjetDistantRepository $objetDistantRepository
     * @param ObjetDistantHelper $objetHelper
     */
     public function __construct(ObjetDistantRepository $objetDistantRepository, ObjetDistantHelper $objetHelper,
                                 Pagination             $pagination)
     {
         $this->objetHelper = $objetHelper;
         $this->objetDistantRepository = $objetDistantRepository;
         $this->pagination = $pagination;
     }


     public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
     {
         return ObjetDistant::class === $resourceClass && ('get' === $operationName);
     }

     public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
     {


         $query = $this->objetDistantRepository->findByAttribut($context);

        if(!empty($context["constelllation"]) && is_array($context["constellation"]) &&
            count($context["constellation"]) > 0)
        {
            $query = $this->objetDistantRepository->findByConstellations($query, $context["constellation"]);
        }


         list($currentPage, $offset, $resultMax) = $this->pagination->getPagination($resourceClass, $operationName, $context);

        $paginator = new ObjetDistantPaginator($this->objetHelper, $currentPage, $resultMax, $context);
        return $paginator;
        //return $this->objetDistantRepository->getResult($query);
     }
}
