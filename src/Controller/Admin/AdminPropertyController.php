<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{
    private $repository;
    private \Doctrine\Persistence\ObjectManager $em;
    
    public function __construct(PropertyRepository $repository, ManagerRegistry $registry)
    {
        $this->repository = $repository;
        $this->em = $registry->getManager();
    }
    
    #[Route('/admin', name: 'admin.property.index')]
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }
    
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    #[Route('/admin/property/create', name: 'admin.property.new')]
    public function new(Request $request)
    {
        $property = new Property();
        
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
    
    
    /**
     * @param Property $property
     *
     * @return Response
     */
    #[Route('/admin/property/{id}', name: 'admin.property.edit', methods: 'GET|POST')]
    public function edit(Property $property, Request $request): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('admin.property.index');
        }
        
        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/admin/property/{id}', name: 'admin.property.delete', methods: 'DELETE')]
    public function delete(Property $property)
    {
        dump('suppression');
        //$this->em->remove($property);
        //$this->em->flush();
        return $this->redirectToRoute('admin.property.index');
    }
}