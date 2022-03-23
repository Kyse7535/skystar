<?php
namespace App\Filter;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractContextAwareFilter;
use ApiPlatform\Core\Serializer\Filter\FilterInterface;
use Symfony\Component\HttpFoundation\Request;

final class ConstellationFilter implements FilterInterface
{
    public const NAME_FILTER_CONTEXT = 'latin_name';

    public function apply(Request $request, bool $normalization, array $attributes, array &$context){
        $latinName = $request->query->get('latinName');
        if (!$latinName)
        {
            return;
        }

        $context[self::NAME_FILTER_CONTEXT] = $latinName;

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