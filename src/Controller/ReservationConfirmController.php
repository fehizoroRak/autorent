<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Status;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use App\Repository\PackRepository;
use App\Repository\CityPickupLocationRepository;
use App\Repository\CityDropoffLocationRepository;
use App\Repository\OptionRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationConfirmController extends AbstractController
{
    #[Route('/reservation/confirm', name: 'app_reservation_confirm', methods: ['POST'])]
    public function confirmReservation(
        Request $request,
        CarRepository $carRepository,
        UserRepository $userRepository,
        PackRepository $packRepository,
        CityPickupLocationRepository $cityPickupLocationRepository,
        CityDropoffLocationRepository $cityDropoffLocationRepository,
        OptionRepository $optionRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Récupérer les données du formulaire
        $total = $request->request->get('total');
        $packId = $request->request->get('pack_id');
        $optionIds = $request->request->get('option_ids');

        $carId = $request->request->get('car_id');
        $userId = $request->request->get('user_id');

        // Récupérer les informations de la voiture depuis la base de données
        $car = $carRepository->find($carId);

        // Récupérer les informations de l'utilisateur depuis la base de données
        $user = $userRepository->find($userId);

        // Récupérer les informations du pack depuis la base de données
        $pack = $packRepository->find($packId);

        // Récupérer les options depuis la base de données
        $optionIdsArray = explode(',', $optionIds);
        $options = $optionRepository->findBy(['id' => $optionIdsArray]);

        // Récupérer les informations de la session
        $session = $request->getSession();
        $startDate = new \DateTime($session->get('startDate'));
        $endDate = new \DateTime($session->get('endDate'));
        $startTime = new \DateTime($session->get('startTime'));
        $endTime = new \DateTime($session->get('endTime'));
        $pickupLocationId = $session->get('pickupLocationId');
        $dropoffLocationId = $session->get('dropoffLocationId');
        $days = $session->get('days');

        // Récupérer les informations des lieux depuis la base de données
        $pickupLocation = $cityPickupLocationRepository->find($pickupLocationId);
        $dropoffLocation = $cityDropoffLocationRepository->find($dropoffLocationId);

        // Rediriger ou afficher une confirmation
        return $this->render('reservationconfirm/index.html.twig', [
            'total' => $total,
            'pack' => $pack,
            'pack_id' => $packId,
            'option_ids' => $optionIdsArray,
            'option_names' => array_map(fn($option) => $option->getName(), $options),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'pickupLocationId' => $pickupLocationId,
            'pickupLocationName' => $pickupLocation->getName(),
            'dropoffLocationId' => $dropoffLocationId,
            'dropoffLocationName' => $dropoffLocation->getName(),
            'days' => $days,
            'car' => $car,
            'user' => $user,
        ]);
    }

    private function generateUniqueRentalNumber(EntityManagerInterface $entityManager): string
    {
        do {
            $rentalNumber = str_pad((string)rand(0, 999999999), 9, '0', STR_PAD_LEFT);
            $existingLocation = $entityManager->getRepository(Location::class)->findOneBy(['rentalNumber' => $rentalNumber]);
        } while ($existingLocation !== null);

        return $rentalNumber;
    }

    #[Route('/reservation/confirm/final', name: 'app_reservation_confirm_final', methods: ['POST'])]
    public function finalConfirmReservation(
        Request $request,
        CarRepository $carRepository,
        UserRepository $userRepository,
        PackRepository $packRepository,
        CityPickupLocationRepository $cityPickupLocationRepository,
        CityDropoffLocationRepository $cityDropoffLocationRepository,
        OptionRepository $optionRepository,
        StatusRepository $statusRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Récupérer les données du formulaire
        $total = $request->request->get('total');
        $packId = $request->request->get('pack_id');
        $optionIds = $request->request->get('option_ids');

        $carId = $request->request->get('car_id');
        $userId = $request->request->get('user_id');

        // Récupérer les informations de la voiture depuis la base de données
        $car = $carRepository->find($carId);

        // Récupérer les informations de l'utilisateur depuis la base de données
        $user = $userRepository->find($userId);

        // Récupérer les informations du pack depuis la base de données
        $pack = $packRepository->find($packId);

        // Récupérer les options depuis la base de données
        $optionIdsArray = explode(',', $optionIds);
        $options = $optionRepository->findBy(['id' => $optionIdsArray]);

        // Récupérer les informations de la session
        $session = $request->getSession();
        $startDate = new \DateTime($session->get('startDate'));
        $endDate = new \DateTime($session->get('endDate'));
        $startTime = new \DateTime($session->get('startTime'));
        $endTime = new \DateTime($session->get('endTime'));
        $pickupLocationId = $session->get('pickupLocationId');
        $dropoffLocationId = $session->get('dropoffLocationId');
        $days = $session->get('days');

        // Récupérer les informations des lieux depuis la base de données
        $pickupLocation = $cityPickupLocationRepository->find($pickupLocationId);
        $dropoffLocation = $cityDropoffLocationRepository->find($dropoffLocationId);

        // Créer une nouvelle location
        $location = new Location();
        $location->setUser($user);
        $location->setCar($car);
        $location->setPickupLocation($pickupLocation);
        $location->setDropoffLocation($dropoffLocation);
        $location->setPack($pack);
        $location->setStartdate($startDate);
        $location->setEnddate($endDate);
        $location->setStarttime($startTime);
        $location->setEndtime($endTime);
        $location->setTotalamount($total);
        $location->setNumberOfDays($days);

        // Générer un numéro de réservation unique
        $rentalNumber = $this->generateUniqueRentalNumber($entityManager);
        $location->setRentalNumber($rentalNumber);

        // Ajouter les options à la location
        foreach ($options as $option) {
            $location->addOption($option);
        }

        // Persister la nouvelle location
        $entityManager->persist($location);
        $entityManager->flush(); // Assurez-vous que l'ID de la location est généré avant d'insérer les options

        // Ajouter le statut "Pending"
        $pendingStatus = $statusRepository->findOneBy(['name' => 'Pending']);
        if ($pendingStatus) {
            $location->addStatus($pendingStatus);
            $entityManager->persist($location);
            $entityManager->flush();
        }

        // Rediriger ou afficher une confirmation
        return $this->render('reservationconfirm/success.html.twig', [
            'location' => $location,
            'status' => $pendingStatus,
        ]);
    }
}
