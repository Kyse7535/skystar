<?php
// api/src/Filter/ResearchObjetDistantFilter.php

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Filter\AbstractOwnContextFilter;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;

final class ResearchObjetDistantFilter extends AbstractOwnContextFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        return ;
    }

    protected function filterProperties(array $properties, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        // Initialisation variable
        $ra = array_key_exists("ra", $properties) ? $properties['ra'] : null;
        $dec = array_key_exists("dec", $properties) ? $properties['dec'] : null;
        $magnitude = array_key_exists("magnitude", $properties) ? $properties['magnitude'] : null;
        $constellations = array_key_exists("constellation", $properties) ? $properties['constellation'] : null;

        // Parse par constellations
        if($constellations && is_array($constellations) && count($constellations) > 0){
            $queryBuilder
                ->leftJoin('o.idConstellation', 'idConstellation')
                ->andWhere($queryBuilder->expr()->in('idConstellation', $constellations));
        }

        // Parse par RA - DEC et Magnitude
        if(!empty($ra) && !empty($dec) && !empty($magnitude)) {
            $queryBuilder
                ->andWhere("o.ra >= :raMin")
                ->andWhere("o.ra <= :raMax")
                ->andWhere("o.deca >= :decMin")
                ->andWhere("o.deca <= :decMax")
                ->andWhere("o.magnitude >= :magnitudeMin")
                ->andWhere("o.magnitude <= :magnitudeMax")
                ->setParameter("raMin", $ra - 1)
                ->setParameter("raMax", $ra + 1)
                ->setParameter("decMin", $dec - 1)
                ->setParameter("decMax", $dec + 1)
                ->setParameter("magnitudeMin", $magnitude - 1)
                ->setParameter("magnitudeMax", $magnitude + 1);
        }
    }

    // This function is only used to hook in documentation generators (supported by Swagger and Hydra)
    public function getDescription(string $resourceClass): array
    {
        $description["constellation"] = [
            'property' => 'constellation',
            'type' => Type::BUILTIN_TYPE_ARRAY,
            'required' => false,
            'swagger' => [
                'description' => 'Ce filtre ne récuère que les objets distants appartenant a l\'une des constellations fournis.',
                'name' => 'Constellation',
                'type' => 'Tableau d\'ID de constellation'
            ]
        ];

        return $description;
    }
}