<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create an array of car data
        $carsData = [
            [
                'brand' => 'Toyota',
                'model' => 'Corolla',
                'year' => 2020,
                'color' => 'Red',
                'registration' => 'ABC123',
                'dayprice' => 50.0
            ],
            [
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => 2019,
                'color' => 'Blue',
                'registration' => 'DEF456',
                'dayprice' => 45.0
            ],
            [
                'brand' => 'Ford',
                'model' => 'Focus',
                'year' => 2018,
                'color' => 'Black',
                'registration' => 'GHI789',
                'dayprice' => 40.0
            ],
            [
                'brand' => 'BMW',
                'model' => '3 Series',
                'year' => 2021,
                'color' => 'White',
                'registration' => 'JKL012',
                'dayprice' => 60.0
            ],
            [
                'brand' => 'Mercedes',
                'model' => 'C-Class',
                'year' => 2022,
                'color' => 'Silver',
                'registration' => 'MNO345',
                'dayprice' => 70.0
            ],
            [
                'brand' => 'Audi',
                'model' => 'A4',
                'year' => 2017,
                'color' => 'Gray',
                'registration' => 'PQR678',
                'dayprice' => 55.0
            ],
            [
                'brand' => 'Volkswagen',
                'model' => 'Golf',
                'year' => 2016,
                'color' => 'Green',
                'registration' => 'STU901',
                'dayprice' => 35.0
            ],
            [
                'brand' => 'Chevrolet',
                'model' => 'Malibu',
                'year' => 2015,
                'color' => 'Brown',
                'registration' => 'VWX234',
                'dayprice' => 30.0
            ],
            [
                'brand' => 'Nissan',
                'model' => 'Altima',
                'year' => 2014,
                'color' => 'Yellow',
                'registration' => 'YZA567',
                'dayprice' => 25.0
            ],
            [
                'brand' => 'Kia',
                'model' => 'Optima',
                'year' => 2013,
                'color' => 'Purple',
                'registration' => 'BCD890',
                'dayprice' => 20.0
            ],
        ];

        // Create and persist each car
        foreach ($carsData as $carData) {
            $car = new Car();
            $car->setBrand($carData['brand']);
            $car->setModel($carData['model']);
            $car->setYear($carData['year']);
            $car->setColor($carData['color']);
            $car->setRegistration($carData['registration']);
            $car->setDayprice($carData['dayprice']);
            
            $manager->persist($car);
        }

        // Flush all cars to the database
        $manager->flush();
    }
}
