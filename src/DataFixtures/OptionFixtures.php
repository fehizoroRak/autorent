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
            [
                'name' => 'Conducteur additionnel',
                'price' => 25.99,
                'content' => 'Ajoutez un conducteur supplémentaire à votre contrat de location.',
                'image' => 'conducteur_additionnel.png'
            ],
            [
                'name' => 'Siège de sécurité bébé (0-12 mois)',
                'price' => 28.01,
                'content' => 'Assurez la sécurité de votre bébé avec notre siège de sécurité.',
                'image' => 'siege_bebe.png'
            ],
            [
                'name' => 'Système de navigation GPS',
                'price' => 40.01,
                'content' => 'Trouvez facilement votre chemin avec notre GPS intégré.',
                'image' => 'gps.png'
            ],
            [
                'name' => 'Rehausseur enfant (4-7 ans)',
                'price' => 18.00,
                'content' => 'Assurez la sécurité de votre enfant avec notre rehausseur.',
                'image' => 'rehausseur_enfant.png'
            ],
        ];

        foreach ($options as $optionData) {
            $option = new Option();
            $option->setName($optionData['name']);
            $option->setPrice($optionData['price']);
            $option->setContent($optionData['content']);
            $option->setImage($optionData['image']);
            $manager->persist($option);
            $this->addReference('option-' . strtolower(str_replace(' ', '-', $optionData['name'])), $option);
        }

        $manager->flush();
    }
}
