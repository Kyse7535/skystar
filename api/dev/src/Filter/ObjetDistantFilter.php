<?php
namespace App\Filter;

use ApiPlatform\Core\Serializer\Filter\FilterInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Filter\ObjetFilter;

final class ObjetDistantFilter extends ObjetFilter
{
    public function apply(Request $request, bool $normalization, array $attributes, array &$context){
        parent::apply($request, $normalization, $attributes, $context);
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            
        ];
    }
}