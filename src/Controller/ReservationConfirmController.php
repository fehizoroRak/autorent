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
        $packId = $request->request->get('pack_id');
        $packName = $request->request->get('pack_name');
        $optionIds = $request->request->get('option_ids');
        $optionNames = $request->request->get('option_names');

        if (is_null($packId) || is_null($packName) || is_null($optionIds) || is_null($optionNames)) {
            return new Response('Some form fields are missing.', Response::HTTP_BAD_REQUEST);
        }

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

        $pickupLocationId = $session->get('pickupLocationId');
        $pickupLocationName = $session->get('pickupLocationName');

        $dropoffLocationId = $session->get('dropoffLocationId');
        $dropoffLocationName = $session->get('dropoffLocationName');

        $days = $session->get('days');

        // Convertir les options IDs et noms en tableaux
        $optionIdsArray = explode(',', $optionIds);
        $optionNamesArray = explode(',', $optionNames);

        return $this->render('reservationconfirm/index.html.twig', [
            'total' => $total,
            'pack_id' => $packId,
            'pack_name' => $packName,
            'option_ids' => $optionIdsArray,
            'option_names' => $optionNamesArray,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'start_time' => $startTime,
            'end_time' => $endTime,

            'pickupLocationId' => $pickupLocationId,
            'pickupLocationName' => $pickupLocationName,

            'dropoffLocationId' => $dropoffLocationId,
            'dropoffLocationName' => $dropoffLocationName,

            'days' => $days,
            'car' => $car,
            'user' => $user,
        ]);
    }
}
