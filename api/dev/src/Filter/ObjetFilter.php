<?php
namespace App\Filter;

use ApiPlatform\Core\Serializer\Filter\FilterInterface;
use Symfony\Component\HttpFoundation\Request;

class ObjetFilter implements FilterInterface
{
    public const RA_FILTER_CONTEXT = 'ra';
    public const DEC_FILTER_CONTEXT = 'dec';
    public const MAGNITUDE_FILTER_CONTEXT = 'magnitude';
    public const CONSTELLATION_FILTER_CONTEXT = 'constellation';

    public function apply(Request $request, bool $normalization, array $attributes, array &$context){
        $ra = $request->query->get(self::RA_FILTER_CONTEXT) ;
        $dec = $request->query->get(self::DEC_FILTER_CONTEXT);
        $magnitude = $request->query->get(self::MAGNITUDE_FILTER_CONTEXT);
        $constellation = $request->query->all(self::CONSTELLATION_FILTER_CONTEXT);
        
        if (is_numeric($ra)) {
            $context[self::RA_FILTER_CONTEXT] = $ra;
        }
        if (is_numeric($dec)) {
            $context[self::DEC_FILTER_CONTEXT] = $dec;
        }
        if (is_numeric($magnitude)) {
            $context[self::MAGNITUDE_FILTER_CONTEXT] = $magnitude;
        }
        if (is_array($constellation)) {
            $context[self::CONSTELLATION_FILTER_CONTEXT] = $constellation;
        }
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            
        ];
    }
}