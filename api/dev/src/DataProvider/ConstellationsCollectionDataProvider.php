<?php

 namespace App\DataProvider;

 use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
 use App\Entity\Constellation;
 use App\Filter\ConstellationFilter;
 use App\Repository\ConstellationRepository;
 use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;


 final class ConstellationsCollectionDataProvider implements ContextAwareCollectionDataProviderInterface,
     RestrictedDataProviderInterface
 {
     private $constellationRepository;

     /**
      * @param $constellationRepository
      */
     public function __construct(ConstellationRepository $constellationRepository)
     {
         $this->constellationRepository = $constellationRepository;
     }


     public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
     {
         return Constellation::class === $resourceClass && ('get' === $operationName);
     }

     public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
     {
         $latinName = $context[ConstellationFilter::NAME_FILTER_CONTEXT] ?? null;
         return $this->constellationRepository->findFithFirst() ?? null;
     }

 }