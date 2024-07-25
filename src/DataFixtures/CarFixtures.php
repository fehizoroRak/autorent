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
                'dayprice' => 50.0,
                'availability' => true,
                'image' => 'toyota_corolla.jpg',
                'nbofcardoors' => 4,
                'nbofpersons' => 5,
                'isAirconditionner' => true,
                'gearbox' => 'Automatique',
                'horsepower' => 132,
                'co2emissions' => 120,
                'isElectric' => false,
            ],
            [
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => 2019,
                'color' => 'Blue',
                'registration' => 'DEF456',
                'dayprice' => 45.0,
                'availability' => true,
                'image' => 'honda_civic.jpg',
                'nbofcardoors' => 4,
                'nbofpersons' => 5,
                'isAirconditionner' => true,
                'gearbox' => 'Automatique',
                'horsepower' => 158,
                'co2emissions' => 125,
                'isElectric' => true,
            ],
            [
                'brand' => 'Ford',
                'model' => 'Focus',
                'year' => 2018,
                'color' => 'Black',
                'registration' => 'GHI789',
                'dayprice' => 40.0,
                'availability' => false,
                'image' => 'ford_focus.jpg',
                'nbofcardoors' => 4,
                'nbofpersons' => 5,
                'isAirconditionner' => true,
                'gearbox' => 'Manuelle',
                'horsepower' => 160,
                'co2emissions' => 130,
                'isElectric' => false,
            ],
            [
                'brand' => 'BMW',
                'model' => '3 Series',
                'year' => 2021,
                'color' => 'White',
                'registration' => 'JKL012',
                'dayprice' => 60.0,
                'availability' => true,
                'image' => 'bmw_3_series.jpg',
                'nbofcardoors' => 4,
                'nbofpersons' => 5,
                'isAirconditionner' => true,
                'gearbox' => 'Automatique',
                'horsepower' => 255,
                'co2emissions' => 140,
                'isElectric' => true,
            ],
            [
                'brand' => 'Mercedes',
                'model' => 'C-Class',
                'year' => 2022,
                'color' => 'Silver',
                'registration' => 'MNO345',
                'dayprice' => 70.0,
                'availability' => true,
                'image' => 'mercedes_c_class.jpg',
                'nbofcardoors' => 4,
                'nbofpersons' => 5,
                'isAirconditionner' => true,
                'gearbox' => 'Automatique',
                'horsepower' => 255,
                'co2emissions' => 135,
                'isElectric' => false,
            ],
            [
                'brand' => 'Audi',
                'model' => 'A4',
                'year' => 2017,
                'color' => 'Gray',
                'registration' => 'PQR678',
                'dayprice' => 55.0,
                'availability' => false,
                'image' => 'audi_a4.jpg',
                'nbofcardoors' => 4,
                'nbofpersons' => 5,
                'isAirconditionner' => true,
                'gearbox' => 'Manuelle',
                'horsepower' => 188,
                'co2emissions' => 150,
                'isElectric' => true,
            ],
            [
                'brand' => 'Volkswagen',
                'model' => 'Golf',
                'year' => 2016,
                'color' => 'Green',
                'registration' => 'STU901',
                'dayprice' => 35.0,
                'availability' => true,
                'image' => 'volkswagen_golf.jpg',
                'nbofcardoors' => 4,
                'nbofpersons' => 5,
                'isAirconditionner' => true,
                'gearbox' => 'Manuelle',
                'horsepower' => 147,
                'co2emissions' => 120,
                'isElectric' => false,
            ],
            [
                'brand' => 'Chevrolet',
                'model' => 'Malibu',
                'year' => 2015,
                'color' => 'Brown',
                'registration' => 'VWX234',
                'dayprice' => 30.0,
                'availability' => true,
                'image' => 'chevrolet_malibu.jpg',
                'nbofcardoors' => 4,
                'nbofpersons' => 5,
                'isAirconditionner' => true,
                'gearbox' => 'Automatique',
                'horsepower' => 160,
                'co2emissions' => 140,
                'isElectric' => true,
            ],
            [
                'brand' => 'Nissan',
                'model' => 'Altima',
                'year' => 2014,
                'color' => 'Yellow',
                'registration' => 'YZA567',
                'dayprice' => 25.0,
                'availability' => false,
                'image' => 'nissan_altima.jpg',
                'nbofcardoors' => 4,
                'nbofpersons' => 5,
                'isAirconditionner' => true,
                'gearbox' => 'Automatique',
                'horsepower' => 182,
                'co2emissions' => 135,
                'isElectric' => false,
            ],
            [
                'brand' => 'Kia',
                'model' => 'Optima',
                'year' => 2013,
                'color' => 'Purple',
                'registration' => 'BCD890',
                'dayprice' => 20.0,
                'availability' => true,
                'image' => 'kia_optima.jpg',
                'nbofcardoors' => 4,
                'nbofpersons' => 5,
                'isAirconditionner' => true,
                'gearbox' => 'Manuelle',
                'horsepower' => 185,
                'co2emissions' => 145,
                'isElectric' => true,
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
            $car->setAvailability($carData['availability']);
            $car->setImage($carData['image']); // Set image
            $car->setNbofcardoors($carData['nbofcardoors']);
            $car->setNbofpersons($carData['nbofpersons']);
            $car->setAirconditionner($carData['isAirconditionner']);
            $car->setGearbox($carData['gearbox']);
            $car->setHorsepower($carData['horsepower']);
            $car->setCo2emissions($carData['co2emissions']);
            $car->setElectric($carData['isElectric']);

            $manager->persist($car);
        }

        // Flush all cars to the database
        $manager->flush();
    }
}
