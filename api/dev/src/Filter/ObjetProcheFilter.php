<?php
namespace App\Filter;

use ApiPlatform\Core\Serializer\Filter\FilterInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Filter\ObjetFilter;

final class ObjetProcheFilter extends ObjetFilter
{
    public const FILTER_CONTEXT = 'filter';

    public function apply(Request $request, bool $normalization, array $attributes, array &$context){
        parent::apply($request, $normalization, $attributes, $context);

        $filter = $request->query->get(self::FILTER_CONTEXT);

        if (!empty($filter)) {
            $context[self::FILTER_CONTEXT] = $filter;
        }
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'filter' => [
                'property' => null,
                'type' => 'string',
                'required' => false,
            ]
        ];
    }
}