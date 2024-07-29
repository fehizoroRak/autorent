<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvailableCarsController extends AbstractController
{
    #[Route('/cars/available', name: 'app_cars_available')]
    public function availableCars(Request $request, CarRepository $carRepository): Response
    {
        // Récupérer les paramètres de la requête
        $pickupLocation = $request->query->get('pickupLocation');
        $dropoffLocation = $request->query->get('dropoffLocation');
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

        // Requête pour récupérer les voitures disponibles
        $cars = $carRepository->findAvailableCars($startDate, $endDate, $pickupLocation, $dropoffLocation);

        // Récupérer les voitures recommandées
        $recommendedCars = $carRepository->findRecommendedCars();

        return $this->render('availablecars/availablecars.html.twig', [
            'cars' => $cars,
            'recommendedCars' => $recommendedCars,
            'days' => $days,
            'pickupLocation' => $pickupLocation,
            'dropoffLocation' => $dropoffLocation,
            'startDate' => $startDate ? $startDate->format('Y-m-d') : '',
            'startTime' => $startTime ? $startTime->format('H:i') : '',
            'endDate' => $endDate ? $endDate->format('Y-m-d') : '',
            'endTime' => $endTime ? $endTime->format('H:i') : '',
        ]);
    }
}
