<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Entity\ObjetDistant;
use App\Filter\ObjetDistantFilter;
use App\Repository\ObjetDistantRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;

final class ObjetDistantCollectionDataProvider implements ContextAwareCollectionDataProviderInterface,
RestrictedDataProviderInterface
{
    private $objetDistantRepository;

     /**
      * @param $objetDistantRepository
      */
     public function __construct(ObjetDistantRepository $objetDistantRepository)
     {
         $this->objetDistantRepository = $objetDistantRepository;
     }


     public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
     {
         return ObjetDistant::class === $resourceClass && ('get' === $operationName);
     }

     public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
     {
        $ra = key_exists("ra", $context) ? intval($context[ObjetDistantFilter::RA_FILTER_CONTEXT]) : null;
        $dec = key_exists('dec', $context) ? intval($context[ObjetDistantFilter::DEC_FILTER_CONTEXT]) : null;
        $magnitude = key_exists('magnitude', $context) ? intval($context[ObjetDistantFilter::MAGNITUDE_FILTER_CONTEXT]) : null;
        $constellations = key_exists('constellation', $context) ? $context[ObjetDistantFilter::CONSTELLATION_FILTER_CONTEXT] : null;

        if(!empty($constellations) && is_array($constellations) && count($constellations) > 0){
            return $this->objetDistantRepository->findByConstellations($constellations) ?? [];
        }

        return $this->objetDistantRepository->findFithFirst() ;
     }
}
