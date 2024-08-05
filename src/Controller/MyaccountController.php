<?php

namespace App\Controller;

use App\Entity\Location;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class MyaccountController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/myaccount', name: 'app_myaccount')]
    public function index(): Response
    {
        $user = $this->security->getUser();
        $locations = $this->entityManager->getRepository(Location::class)->findBy(['user' => $user]);

        return $this->render('myaccount/index.html.twig', [
            'locations' => $locations,
        ]);
    }

    #[Route('/myaccount/details/{id}', name: 'app_myaccount_details')]
    public function details(int $id): Response
    {
        $location = $this->entityManager->getRepository(Location::class)->find($id);

        if (!$location) {
            throw $this->createNotFoundException('La location n\'existe pas');
        }

        return $this->render('myaccount/details.html.twig', [
            'location' => $location,
        ]);
    }
}
