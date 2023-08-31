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
        $property = $this->repository->findAllVisible();
        dump($property);
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }
}