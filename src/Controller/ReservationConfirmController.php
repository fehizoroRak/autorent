<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReservationConfirmController extends AbstractController
{
    #[Route('/reservation/confirm', name: 'app_reservation_confirm')]
    public function index(): Response
    {
        return $this->render('reservationconfirm/index.html.twig', [
            'controller_name' => 'ReservationConfirmController',
        ]);
    }
}
