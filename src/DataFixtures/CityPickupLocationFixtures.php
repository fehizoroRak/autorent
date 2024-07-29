<?php

namespace App\DataFixtures;

use App\Entity\CityPickupLocation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityPickupLocationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cities = [
            'Paris',
            'Marseille',
            'Lyon',
            'Toulouse',
            'Nice',
            'Nantes',
            'Strasbourg',
            'Montpellier',
            'Bordeaux',
            'Lille',
            'Rennes',
            'Reims',
            'Le Havre',
            'Saint-Étienne',
            'Toulon',
            'Grenoble',
            'Dijon',
            'Angers',
            'Nîmes',
            'Villeurbanne',
        ];

        foreach ($cities as $cityName) {
            $city = new CityPickupLocation();
            $city->setName($cityName);
            $manager->persist($city);
        }

        $manager->flush();
    }
}
