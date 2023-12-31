<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private PropertyRepository $repository;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, PropertyRepository $repository)
    {
        $this->entityManager = $registry->getManager();
        $this->repository = $repository;
    }
    
    /**
     *
     * @return Response
     */
    #[Route('/biens', name: 'property.index')]
    public function index(): Response
    {
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }

    #[Route('/biens/{slug}-{id}', name: 'property.show', requirements: ['slug' => "[a-z0-9\-]*"])]
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
           return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);

        }
        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }
}