<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarRepository;
use App\Repository\UserRepository;

class ReservationConfirmController extends AbstractController
{
    #[Route('/reservation/confirm', name: 'app_reservation_confirm', methods: ['POST'])]
    public function index(Request $request, CarRepository $carRepository, UserRepository $userRepository): Response
    {
        // Récupérer les données du formulaire
        $total = $request->request->get('total');
        $pack = $request->request->get('pack');
        $options = $request->request->get('options');
        $carId = $request->request->get('car_id');
        $userId = $request->request->get('user_id');

        // Récupérer les informations de la voiture depuis la base de données
        $car = $carRepository->find($carId);

        // Récupérer les informations de l'utilisateur depuis la base de données
        $user = $userRepository->find($userId);

        // Récupérer les informations de la session
        $session = $request->getSession();
        $startDate = $session->get('startDate');
        $endDate = $session->get('endDate');
        $startTime = $session->get('startTime');
        $endTime = $session->get('endTime');
        $pickupLocation = $session->get('pickupLocation');
        $dropoffLocation = $session->get('dropoffLocation');
        $days = $session->get('days');

        return $this->render('reservationconfirm/index.html.twig', [
            'total' => $total,
            'pack' => $pack,
            'options' => $options,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'pickup_location' => $pickupLocation,
            'dropoff_location' => $dropoffLocation,
            'days' => $days,
            'car' => $car,
            'user' => $user,
        ]);
    }
}
