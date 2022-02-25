creation api filter avec des data providers.
==================

Pour chaque entité:

1. #### Creer un data provider personnalisé
[Lien vers la doc](https://api-platform.com/docs/core/data-providers/#custom-collection-data-provider)

2. #### Creer une filter personnalisé: ex ObjetDistantFilter
2.1. Creer une classe qui implemente FilterInterface
2.2 Creer une finction apply
 `
 public function apply(Request $request, bool $normalization, array $attributes, array &$context)
 {
 }
 `

cette fonction sera automatiquement appelé lorsque l'on fera une requete sur
un objet qui utilise le filtre ObjetDistantFilter
cette methode permet de récupérer tous les paramètres de la requête

2.3 Ajouter #[ApiFilter(ObjetDistantFilter::class)] à l'entité objetDistant
2.4. Ajouter #[ApiProperty(identifier: true)] à l'id de l'entité objetDistant


