<?php

namespace App\DataFixtures;

use App\Entity\Pack;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PackFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $packs = [
            ['name' => 'Basic', 'pricePerDay' => 0],
            ['name' => 'Medium', 'pricePerDay' => 25],
            ['name' => 'Premium', 'pricePerDay' => 50],
        ];

        foreach ($packs as $packData) {
            $pack = new Pack();
            $pack->setName($packData['name']);
            $pack->setPricePerDay($packData['pricePerDay']);
            $manager->persist($pack);
            $this->addReference('pack-' . strtolower($packData['name']), $pack);
        }

        $manager->flush();
    }
}
