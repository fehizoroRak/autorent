<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\User;
use App\Entity\Car;
use App\Entity\Pack;
use App\Entity\Option;
use App\Entity\CityPickupLocation;
use App\Entity\CityDropoffLocation;
use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LocationFixtures extends Fixture implements DependentFixtureInterface
{
    private function generateUniqueRentalNumber(array $existingNumbers): string
    {
        do {
            $rentalNumber = str_pad((string)rand(0, 999999999), 9, '0', STR_PAD_LEFT);
        } while (in_array($rentalNumber, $existingNumbers));

        return $rentalNumber;
    }

    public function load(ObjectManager $manager): void
    {
        // Retrieve all required entities from the database
        $users = $manager->getRepository(User::class)->findAll();
        $cars = $manager->getRepository(Car::class)->findAll();
        $pickupLocations = $manager->getRepository(CityPickupLocation::class)->findAll();
        $dropoffLocations = $manager->getRepository(CityDropoffLocation::class)->findAll();
        $packs = $manager->getRepository(Pack::class)->findAll();
        $options = $manager->getRepository(Option::class)->findAll();
        $statuses = $manager->getRepository(Status::class)->findAll();

        // Ensure there are enough records to create 10 locations
        if (count($users) < 10 || count($cars) < 10 || count($pickupLocations) < 10 || count($dropoffLocations) < 10) {
            throw new \Exception('Not enough users, cars, pickup locations, or dropoff locations to create 10 locations.');
        }

        // Store existing rental numbers to ensure uniqueness
        $existingRentalNumbers = [];

        // Create 10 locations with random data
        for ($i = 0; $i < 10; $i++) {
            $location = new Location();

            // Random start and end dates
            $startDate = new \DateTime(sprintf('-%d days', rand(1, 30)));
            $endDate = (clone $startDate)->modify(sprintf('+%d days', rand(1, 10)));

            // Random start and end times
            $startTime = (new \DateTime())->setTime(rand(0, 23), rand(0, 59));
            $endTime = (clone $startTime)->modify(sprintf('+%d hours', rand(1, 12)));

            // Assign random user, car, pickup and dropoff locations, pack
            $location->setStartdate($startDate);
            $location->setEnddate($endDate);
            $location->setStarttime($startTime);
            $location->setEndtime($endTime);
            $location->setUser($users[array_rand($users)]);
            $location->setCar($cars[array_rand($cars)]);
            $location->setPickupLocation($pickupLocations[array_rand($pickupLocations)]);
            $location->setDropoffLocation($dropoffLocations[array_rand($dropoffLocations)]);
            $location->setPack($packs[array_rand($packs)]);

            // Assign random options
            $randomOptions = array_rand($options, rand(1, count($options)));
            if (!is_array($randomOptions)) {
                $randomOptions = [$randomOptions];
            }
            foreach ($randomOptions as $optionIndex) {
                $location->addOption($options[$optionIndex]);
            }

            // Calculate and set number of days
            $numberOfDays = $endDate->diff($startDate)->days;
            $location->setNumberOfDays($numberOfDays);

            // Set pack price and options total price
            $packPricePerDay = $location->getPack()->getPricePerDay();
            $packTotalPrice = $packPricePerDay * $numberOfDays;
            $location->setPackTotalPrice($packTotalPrice);

            $optionsTotalPrice = 0;
            foreach ($location->getOptions() as $option) {
                $optionsTotalPrice += $option->getPrice();
            }
            $location->setOptionsTotalPrice($optionsTotalPrice);

            // Calculate total amount
            $totalAmount = $packTotalPrice + $optionsTotalPrice;
            $location->setTotalamount($totalAmount);

            // Set initial status to "Pending" and add to status history
            $pendingStatus = array_filter($statuses, fn($status) => $status->getName() === 'Pending');
            if (!empty($pendingStatus)) {
                $location->addStatus(reset($pendingStatus));
            } else {
                throw new \Exception('Status "Pending" not found.');
            }

            // Generate unique rental number
            $rentalNumber = $this->generateUniqueRentalNumber($existingRentalNumbers);
            $location->setRentalNumber($rentalNumber);
            $existingRentalNumbers[] = $rentalNumber;

            $manager->persist($location);
        }

        // Persist all changes to the database
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
            StatusFixtures::class,
        ];
    }
}
