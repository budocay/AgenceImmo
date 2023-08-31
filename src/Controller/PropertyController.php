<?php

namespace App\Controller;

use App\Entity\Property;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    
    public function __construct(ManagerRegistry $registry)
    {
        $this->entityManager = $registry->getManager();
    }
    
    /**
     *
     * @return Response
     */
    #[Route('/biens', name: 'property.index')]
    public function index(): Response
    {
        $property = new Property();
        $property->setTitle('Mon premier bien')
            ->setPrice(200000)
            ->setRooms(4)
            ->setBedrooms(3)
            ->setDescription('Une petite description')
            ->setSurface(60)
            ->setFloor(4)
            ->setHeat(1)
            ->setCity('Montpellier')
            ->setAddress('15 boulevard Gambetta')
            ->setPostalCode('34000');
        $this->entityManager->persist($property);
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }
}