<?php

namespace App\Controller;

use App\Repository\CarRepository;
use App\Repository\CityDropoffLocationRepository;
use App\Repository\CityPickupLocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AvailableCarsController extends AbstractController
{
    #[Route('/cars/available', name: 'app_cars_available')]
    public function availableCars(
        Request $request,
        CarRepository $carRepository,
        CityPickupLocationRepository $cityPickupLocationRepository,
        CityDropoffLocationRepository $cityDropoffLocationRepository,
        SessionInterface $session
    ): Response {
        // Récupérer les paramètres de la requête
        $pickupLocationName = $request->query->get('pickupLocation');
        $dropoffLocationName = $request->query->get('dropoffLocation');
        $startDate = $request->query->get('startDate') ? new \DateTime($request->query->get('startDate')) : null;
        $startTime = $request->query->get('startTime') ? new \DateTime($request->query->get('startTime')) : null;
        $endDate = $request->query->get('endDate') ? new \DateTime($request->query->get('endDate')) : null;
        $endTime = $request->query->get('endTime') ? new \DateTime($request->query->get('endTime')) : null;

        // Combiner date et heure pour startDate et endDate
        if ($startDate && $startTime) {
            $startDate->setTime($startTime->format('H'), $startTime->format('i'));
        }

        if ($endDate && $endTime) {
            $endDate->setTime($endTime->format('H'), $endTime->format('i'));
        }

        // Récupérer le nombre de jours
        $interval = $startDate->diff($endDate);
        $days = $interval->days;

        // Récupérer les IDs des lieux à partir des noms
        $pickupLocation = $cityPickupLocationRepository->findOneBy(['name' => $pickupLocationName]);
        $dropoffLocation = $cityDropoffLocationRepository->findOneBy(['name' => $dropoffLocationName]);

        $pickupLocationId = $pickupLocation ? $pickupLocation->getId() : null;
        $dropoffLocationId = $dropoffLocation ? $dropoffLocation->getId() : null;
 

        // Stocker les variables dans la session
        $session->set('days', $days);
        $session->set('pickupLocationId', $pickupLocationId);
        $session->set('pickupLocationName', $pickupLocationName);
        $session->set('dropoffLocationId', $dropoffLocationId);
        $session->set('dropoffLocationName', $dropoffLocationName);
        $session->set('startDate', $startDate ? $startDate->format('Y-m-d') : '');
        $session->set('startTime', $startTime ? $startTime->format('H:i') : '');
        $session->set('endDate', $endDate ? $endDate->format('Y-m-d') : '');
        $session->set('endTime', $endTime ? $endTime->format('H:i') : '');

        // Requête pour récupérer les voitures disponibles
        $cars = $carRepository->findAvailableCars($startDate, $endDate, $pickupLocationId, $dropoffLocationId);

        // Récupérer les voitures recommandées
        $recommendedCars = $carRepository->findRecommendedCars();

        return $this->render('availablecars/availablecars.html.twig', [
            'cars' => $cars,
            'recommendedCars' => $recommendedCars,
            'days' => $days,
            'pickupLocation' => $pickupLocationName,
            'dropoffLocation' => $dropoffLocationName,
            'startDate' => $startDate ? $startDate->format('d/m/Y') : '',
            'startTime' => $startTime ? $startTime->format('H:i') : '',
            'endDate' => $endDate ? $endDate->format('d/m/Y') : '',
            'endTime' => $endTime ? $endTime->format('H:i') : '',
        ]);
    }


    #[Route('/cars/available/{id}', name: 'app_cars_available_details')]
    public function availableCarDetails(int $id, CarRepository $carRepository): Response
    {
        // Récupérer la voiture par ID
        $car = $carRepository->find($id);

        // Si la voiture n'existe pas, lever une exception ou rediriger vers une autre page
        if (!$car) {
            throw $this->createNotFoundException('The car does not exist');
        }

        // Rediriger vers la page de détails de la voiture
        return $this->render('availablecars/availablecars_details.html.twig', [
            'car' => $car,
        ]);
    }

    #[Route('/cars/session', name: 'app_cars_session_data')]
    public function getSessionData(SessionInterface $session): JsonResponse
    {
        // Récupérer les données de la session
        $data = [
            'days' => $session->get('days'),
            'pickupLocationId' => $session->get('pickupLocationId'),
            'pickupLocationName' => $session->get('pickupLocationName'),
            'dropoffLocationId' => $session->get('dropoffLocationId'),
            'dropoffLocationName' => $session->get('dropoffLocationName'),
            'startDate' => $session->get('startDate'),
            'startTime' => $session->get('startTime'),
            'endDate' => $session->get('endDate'),
            'endTime' => $session->get('endTime'),
        ];

        // Retourner les données sous forme de JSON
        return new JsonResponse($data);
    }

}
