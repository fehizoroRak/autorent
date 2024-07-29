<?php

namespace App\DataFixtures;

use App\Entity\Option;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OptionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $options = [
            ['name' => 'Conducteur additionnel', 'price' => 25.99],
            ['name' => 'Siège de sécurité bébé (0-12 mois)', 'price' => 28.01],
            ['name' => 'Système de navigation GPS', 'price' => 40.01],
            ['name' => 'Rehausseur enfant (4-7 ans)', 'price' => 18.00],
        ];

        foreach ($options as $optionData) {
            $option = new Option();
            $option->setName($optionData['name']);
            $option->setPrice($optionData['price']);
            $manager->persist($option);
            $this->addReference('option-' . strtolower(str_replace(' ', '-', $optionData['name'])), $option);
        }

        $manager->flush();
    }
}
