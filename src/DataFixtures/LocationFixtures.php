<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\User;
use App\Entity\Car;
use App\Entity\Pack;
use App\Entity\Option;
use App\Entity\CityPickupLocation;
use App\Entity\CityDropoffLocation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LocationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Retrieve all users, cars, pickup and dropoff locations, packs and options from the database
        $users = $manager->getRepository(User::class)->findAll();
        $cars = $manager->getRepository(Car::class)->findAll();
        $pickupLocations = $manager->getRepository(CityPickupLocation::class)->findAll();
        $dropoffLocations = $manager->getRepository(CityDropoffLocation::class)->findAll();
        $packs = $manager->getRepository(Pack::class)->findAll();
        $options = $manager->getRepository(Option::class)->findAll();

        // Ensure we have enough data to create 10 locations
        if (count($users) < 10 || count($cars) < 10 || count($pickupLocations) < 10 || count($dropoffLocations) < 10) {
            throw new \Exception('Not enough users, cars, pickup locations, or dropoff locations to create 10 locations.');
        }

        // Create 10 locations with random data
        for ($i = 0; $i < 10; $i++) {
            $location = new Location();
            $startDate = new \DateTime(sprintf('-%d days', rand(1, 30)));
            $endDate = (clone $startDate)->modify(sprintf('+%d days', rand(1, 10)));
            $totalAmount = rand(100, 1000);

            // Generate random times
            $startTime = (new \DateTime())->setTime(rand(0, 23), rand(0, 59));
            $endTime = (clone $startTime)->modify(sprintf('+%d hours', rand(1, 12)));

            $location->setStartdate($startDate);
            $location->setEnddate($endDate);
            $location->setStarttime($startTime);
            $location->setEndtime($endTime);
            $location->setTotalamount($totalAmount);
            $location->setUser($users[array_rand($users)]);
            $location->setCar($cars[array_rand($cars)]);

            // Set random pickup and dropoff locations
            $location->setPickupLocation($pickupLocations[array_rand($pickupLocations)]);
            $location->setDropoffLocation($dropoffLocations[array_rand($dropoffLocations)]);

            // Set random pack
            $randomPack = $packs[array_rand($packs)];
            $location->setPack($randomPack);

            // Set random options
            $randomOptions = array_rand($options, rand(1, count($options)));
            if (!is_array($randomOptions)) {
                $randomOptions = [$randomOptions];
            }
            foreach ($randomOptions as $optionIndex) {
                $location->addOption($options[$optionIndex]);
            }

            // Adjust the total amount based on pack and options
            $days = $endDate->diff($startDate)->days;
            $totalAmount += $randomPack->getPricePerDay() * $days;
            foreach ($location->getOptions() as $option) {
                $totalAmount += $option->getPrice();
            }
            $location->setTotalamount($totalAmount);

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
            CityPickupLocationFixtures::class,
            CityDropoffLocationFixtures::class,
            PackFixtures::class,
            OptionFixtures::class,
        ];
    }
}
