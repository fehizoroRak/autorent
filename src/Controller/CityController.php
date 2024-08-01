<?php

namespace App\Controller;

use App\Repository\CityPickupLocationRepository;
use App\Repository\CityDropoffLocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    #[Route('/cities/pickup', name: 'app_cities_pickup')]
    public function getPickupCities(Request $request, CityPickupLocationRepository $pickupRepo): JsonResponse
    {
        $query = $request->query->get('q');
        $cities = $pickupRepo->findByName($query);

        $cityNames = array_map(function($city) {
            return ['name' => $city->getName()];
        }, $cities);

        return new JsonResponse($cityNames);
    }

    #[Route('/cities/dropoff', name: 'app_cities_dropoff')]
    public function getDropoffCities(Request $request, CityDropoffLocationRepository $dropoffRepo): JsonResponse
    {
        $query = $request->query->get('q');
        $cities = $dropoffRepo->findByName($query);

        $cityNames = array_map(function($city) {
            return ['name' => $city->getName()];
        }, $cities);

        return new JsonResponse($cityNames);
    }
}
