<?php

namespace App\Controller;
use App\Entity\Constellation;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\DataProvider\ConstellationsCollectionDataProvider;

#[AsController]
class FilterById
{
    private EntityManagerInterface $em;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route(
        name: 'get_constellations',
        path: 'api/constellations/under10',
        methods: ['GET'],
        defaults: [
            '_api_resource_class' => Constellation::class,
            '_api_collection_operation_name' => 'get_constellations',
        ],
    )]
    public function __invoke()
    {
        $this->em->getRepository(Constellation::class)->find(5);
    }
}