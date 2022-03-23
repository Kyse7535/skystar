<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Entity\ObjetDistant;
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
        list($currentPage, $offset, $resultMax) = $this->pagination->getPagination($resourceClass, $operationName, $context);

        return new ObjetDistantPaginator($this->objetHelper, $currentPage, $resultMax, $context);
    }
}
