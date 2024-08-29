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

        // Récupérer les paramètres de la requête ou de la session
        $pickupLocationName = $request->query->get('pickupLocation') ?? $session->get('pickupLocationName');
        $dropoffLocationName = $request->query->get('dropoffLocation') ?? $session->get('dropoffLocationName');
        $startDate = $request->query->get('startDate') ? new \DateTime($request->query->get('startDate')) : ($session->get('startDate') ? new \DateTime($session->get('startDate')) : null);
        $startTime = $request->query->get('startTime') ? new \DateTime($request->query->get('startTime')) : null;
        $endDate = $request->query->get('endDate') ? new \DateTime($request->query->get('endDate')) : ($session->get('endDate') ? new \DateTime($session->get('endDate')) : null);
        $endTime = $request->query->get('endTime') ? new \DateTime($request->query->get('endTime')) : null;

        // Combiner date et heure pour startDate et endDate
        if ($startDate && $startTime) {
            $startDate->setTime($startTime->format('H'), $startTime->format('i'));
        }

        if ($endDate && $endTime) {
            $endDate->setTime($endTime->format('H'), $endTime->format('i'));
        }

        // Vérifier que les dates sont présentes avant de calculer l'intervalle
        if ($startDate && $endDate) {
            // Récupérer le nombre de jours
            $interval = $startDate->diff($endDate);
            $days = $interval->days;
        } else {
            // Si les dates ne sont pas présentes, gérer le cas
            $days = 0; // Vous pouvez ajuster cela selon votre logique
        }

        // Récupérer les IDs des lieux à partir des noms
        $pickupLocation = $cityPickupLocationRepository->findOneBy(['name' => $pickupLocationName]);
        $dropoffLocation = $cityDropoffLocationRepository->findOneBy(['name' => $dropoffLocationName]);

        // Gérer les cas où les villes ne sont pas trouvées
        if (!$pickupLocation && !$dropoffLocation) {
            // Les deux villes ne sont pas trouvées
            $this->addFlash('error', "Nous n'avons pas d'agences dans ces villes.");
            return $this->redirectToRoute('app_home'); 
        } elseif (!$pickupLocation) {
            // Seulement la ville de départ n'est pas trouvée
            $this->addFlash('error', "Nous n'avons pas d'agences dans cette ville de départ.");
            return $this->redirectToRoute('app_home'); 
        } elseif (!$dropoffLocation) {
            // Seulement la ville de retour n'est pas trouvée
            $this->addFlash('error', "Nous n'avons pas d'agences dans cette ville de retour.");
            return $this->redirectToRoute('app_home'); 
        }

        $pickupLocationId = $pickupLocation->getId();
        $dropoffLocationId = $dropoffLocation->getId();

        // Stocker les variables dans la session pour réutilisation
        $session->set('days', $days);
        $session->set('pickupLocationId', $pickupLocationId);
        $session->set('pickupLocationName', $pickupLocationName);
        $session->set('dropoffLocationId', $dropoffLocationId);
        $session->set('dropoffLocationName', $dropoffLocationName);
        $session->set('startDate', $startDate ? $startDate->format('Y-m-d') : '');
        $session->set('startTime', $startTime ? $startTime->format('H:i') : '');
        $session->set('endDate', $endDate ? $endDate->format('Y-m-d') : '');
        $session->set('endTime', $endTime ? $endTime->format('H:i') : '');

        // Gestion des filtres supplémentaires
        $priceOrder = $request->query->get('price'); // 'asc' or 'desc'
        $transmission = $request->query->get('gearbox'); // 'manual' or 'automatic'
        $doors = $request->query->get('doors') ? (int) $request->query->get('doors') : null; // Conversion en entier
        $passengers = $request->query->get('passengers') ? (int) $request->query->get('passengers') : null; // Conversion en entier
        $electric = $request->query->get('electric'); // 'electric' or 'not-electric'

        // Requête pour récupérer les voitures disponibles avec les filtres appliqués
        $cars = $carRepository->findAvailableCarsWithFilters(
            $startDate,
            $endDate,
            $pickupLocationId,
            $dropoffLocationId,
            $priceOrder,
            $transmission,
            $doors,
            $passengers,
            $electric,
            $startTime,
            $endTime
        );

        // Récupérer les voitures recommandées (uniquement pour les requêtes non AJAX)
        $recommendedCars = $request->isXmlHttpRequest() ? [] : $carRepository->findRecommendedCars();

        // Si la requête est AJAX, renvoyer uniquement la partie filtrée
        if ($request->isXmlHttpRequest()) {
            return $this->render('availablecars/_cars_list.html.twig', [
                'cars' => $cars,
                'days' => $days,
            ]);
        }

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
            // Ajout des filtres pour une éventuelle réutilisation dans le template
            'selectedPriceOrder' => $priceOrder,
            'selectedTransmission' => $transmission,
            'selectedDoors' => $doors,
            'selectedPassengers' => $passengers,
            'selectedElectric' => $electric,
        ]);
    }

    #[Route('/cars/available/{id}', name: 'app_cars_available_details')]
    public function availableCarDetails(int $id, CarRepository $carRepository): Response
    {
        // Récupérer la voiture par ID
        $car = $carRepository->find($id);

        // Si la voiture n'existe pas, lever une exception ou rediriger vers une autre page
        if (!$car) {
            throw $this->createNotFoundException('La voiture n\'existe pas');
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
