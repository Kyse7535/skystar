<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Entity\ObjetDistant;
use App\Entity\ObjetProche;
use App\Filter\ObjetFilter;
use ApiPlatform\Core\DataProvider\Pagination;
use App\Repository\ObjetRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Doctrine\ORM\QueryBuilder;
use App\Service\ObjetDistantHelper;

final class ObjetCollectionDataProvider implements ContextAwareCollectionDataProviderInterface,
    RestrictedDataProviderInterface
{
    private ObjetRepository $objetRepository;
    private ObjetDistantHelper $objetHelper;
    private $pagination;

    /**
     * @param ObjetRepository $objetRepository
     * @param ObjetDistantHelper $objetHelper
     * @param Pagination $pagination
     */
    public function __construct(ObjetRepository $objetRepository, ObjetDistantHelper $objetHelper, Pagination $pagination)
    {
        $this->objetHelper = $objetHelper;
        $this->objetRepository = $objetRepository;
        $this->pagination = $pagination;
    }


    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return (ObjetDistant::class === $resourceClass)
            && ('get' === $operationName);
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        /*$ra = key_exists("ra", $context) ? intval($context[ObjetFilter::RA_FILTER_CONTEXT]) : null;
        $dec = key_exists('dec', $context) ? intval($context[ObjetFilter::DEC_FILTER_CONTEXT]) : null;
        $magnitude = key_exists('magnitude', $context) ?
            intval($context[ObjetFilter::MAGNITUDE_FILTER_CONTEXT]) : null;
        $constellations = key_exists('constellation', $context) ?
            $context[ObjetFilter::CONSTELLATION_FILTER_CONTEXT] : null;
         $raRangeMin = key_exists('raRangeMin', $context) ?
            $context['raRangeMin'] : null;
         $raRangeMax = key_exists('raRangeMax', $context) ?
             $context['raRangeMax'] : null;
         $decaRangeMin = key_exists('decaRangeMin', $context) ?
             $context['decaRangeMin'] : null;
         $decaRangeMax = key_exists('decaRangeMax', $context) ?
             $context['decaRangeMax'] : null;*/
        $query = $this->objetRepository->findByAttribut($context);

        if(!empty($context["constelllation"]) && is_array($context["constellation"]) &&
            count($context["constellation"]) > 0)
        {
            $query = $this->objetRepository->findByConstellations($query, $context["constellation"]);
        }
        list($currentPage, $offset, $resultMax) = $this->pagination->getPagination($resourceClass, $operationName, $context);


        return new ObjetDistantPaginator($this->objetHelper, $currentPage, $resultMax, $context);
        //return $this->objetDistantRepository->getResult($query);
    }
}
