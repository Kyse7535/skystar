<?php
namespace App\Filter;

use ApiPlatform\Core\Serializer\Filter\FilterInterface;
use Symfony\Component\HttpFoundation\Request;

final class ObjetDistantFilter implements FilterInterface
{
    public const RA_FILTER_CONTEXT = 'ra';
    public const DEC_FILTER_CONTEXT = 'dec';
    public const MAGNITUDE_FILTER_CONTEXT = 'magnitude';
    public const CONSTELLATION_FILTER_CONTEXT = 'constellation';

    public function apply(Request $request, bool $normalization, array $attributes, array &$context){
        $ra = $request->query->get('ra') ;
        $dec = $request->query->get('dec');
        $magnitude = $request->query->get('magnitude') ;
        $constellation = $request->query->get('constellation') ;

        if (!empty($ra)) {
            $context[self::RA_FILTER_CONTEXT] = $ra;
        }
        if (!empty($dec)) {
            $context[self::DEC_FILTER_CONTEXT] = $dec;
        }
        if (!empty($magnitude)) {
            $context[self::MAGNITUDE_FILTER_CONTEXT] = $magnitude;
        }
        if (!empty($constellation)) {
            $context[self::CONSTELLATION_FILTER_CONTEXT] = $constellation;
        }

    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'latinName' => [
                'property' => null,
                'type' => 'string',
                'required' => false,
            ]
        ];
    }
}