<?php

namespace App\Repository;
use Doctrine\ORM\QueryBuilder;

interface ObjetRepositoryInterface
{
    public function findByAttributDataProvider(QueryBuilder $queryBuilder, int $ra, int $deca, int $magnitude, int $raRange, int $decaRange): QueryBuilder;
    public function findByConstellations(QueryBuilder $queryBuilder, array $constellations): QueryBuilder;
    public function getResult(QueryBuilder $queryBuilder);
    public function getIdentifier(): string;
}