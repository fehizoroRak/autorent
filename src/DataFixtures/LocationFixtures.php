<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\User;
use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LocationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Retrieve all users and cars from the database
        $users = $manager->getRepository(User::class)->findAll();
        $cars = $manager->getRepository(Car::class)->findAll();

        // Ensure we have enough users and cars to create 10 locations
        if (count($users) < 10 || count($cars) < 10) {
            throw new \Exception('Not enough users or cars to create 10 locations.');
        }

        // Define possible pickup and dropoff locations
        $locations = ['Paris', 'Lyon', 'Marseille', 'Toulouse', 'Nice', 'Nantes', 'Montpellier', 'Strasbourg', 'Bordeaux', 'Lille'];

        // Create 10 locations with random data
        for ($i = 0; $i < 10; $i++) {
            $location = new Location();
            $startDate = new \DateTime(sprintf('-%d days', rand(1, 30)));
            $endDate = (clone $startDate)->modify(sprintf('+%d days', rand(1, 10)));
            $totalAmount = rand(100, 1000);

            $location->setStartdate($startDate);
            $location->setEnddate($endDate);
            $location->setTotalamount($totalAmount);
            $location->setUser($users[array_rand($users)]);
            $location->setCar($cars[array_rand($cars)]);

            // Set random pickup and dropoff locations
            $location->setPickupLocation($locations[array_rand($locations)]);
            $location->setDropoffLocation($locations[array_rand($locations)]);

            $manager->persist($location);
        }

        // Flush all locations to the database
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CarFixtures::class,
        ];
    }
}
