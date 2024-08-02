<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $statuses = [
            ['name' => 'Pending', 'description' => 'La réservation a été créée, mais n\'a pas encore été confirmée.', 'color' => '#FFCC00'],
            ['name' => 'Confirmed', 'description' => 'La réservation a été confirmée par le système ou par un opérateur.', 'color' => '#00CC66'],
            ['name' => 'Cancelled', 'description' => 'La réservation a été annulée par l\'utilisateur ou par le système.', 'color' => '#FF3300'],
            ['name' => 'Active', 'description' => 'La période de location a commencé et la voiture est actuellement en possession de l\'utilisateur.', 'color' => '#3399FF'],
            ['name' => 'Completed', 'description' => 'La période de location est terminée et la voiture a été retournée.', 'color' => '#666666'],
            ['name' => 'Overdue', 'description' => 'La période de location est terminée, mais la voiture n\'a pas été retournée à temps.', 'color' => '#FF6600'],
        ];

        foreach ($statuses as $statusData) {
            $status = new Status();
            $status->setName($statusData['name']);
            $status->setDescription($statusData['description']);
            $status->setColor($statusData['color']);
            $manager->persist($status);
        }

        $manager->flush();
    }
}

