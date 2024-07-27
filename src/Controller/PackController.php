<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PackController extends AbstractController
{
    #[Route('/pack', name: 'app_pack')]
    public function index(): Response
    {
        return $this->render('pack/index.html.twig', [
            'controller_name' => 'PackController',
        ]);
    }
}
