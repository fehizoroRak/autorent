<?php

namespace App\Controller;

use App\Entity\Car;
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
        $endDate = $request->query->get('endDate') ? new \DateTime($request->query->get('endDate')) : null;

        // Requête pour récupérer les voitures disponibles
        $cars = $carRepository->findAvailableCars($startDate, $endDate, $pickupLocation, $dropoffLocation);

        // Récupérer les voitures recommandées
        $recommendedCars = $carRepository->findRecommendedCars();

        return $this->render('cars/available.html.twig', [
            'cars' => $cars,
            'recommendedCars' => $recommendedCars,
        ]);
    }
}
