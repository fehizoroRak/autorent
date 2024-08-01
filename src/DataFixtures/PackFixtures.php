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
            [
                'name' => 'Basic',
                'pricePerDay' => 0,
                'franchise' => 1700,
                'contents' => [
                    'Protection contre les dommages résultant d\'une collision',
                    'Protection contre le vol',
                    null, // Pas de troisième contenu pour Basic
                    null, // Pas de quatrième contenu pour Basic
                    null, // Pas de cinquième contenu pour Basic
                ],
            ],
            [
                'name' => 'Medium',
                'pricePerDay' => 28,
                'franchise' => 508,
                'contents' => [
                    'Protection contre les dommages résultant d\'une collision',
                    'Protection contre le vol',
                    'Protection bris de glace, phares et pneumatiques',
                    'Protection personnelle accident',
                    null, // Pas de cinquième contenu pour Medium
                ],
            ],
            [
                'name' => 'Premium',
                'pricePerDay' => 30,
                'franchise' => 0,
                'contents' => [
                    'Protection contre les dommages résultant d\'une collision',
                    'Protection contre le vol',
                    'Protection bris de glace, phares et pneumatiques',
                    'Protection personnelle accident',
                    'Protection des biens personnels',
                ],
            ],
        ];

        foreach ($packs as $packData) {
            $pack = new Pack();
            $pack->setName($packData['name']);
            $pack->setPricePerDay($packData['pricePerDay']);
            $pack->setFranchise($packData['franchise']);
            $pack->setContent1($packData['contents'][0]);
            $pack->setContent2($packData['contents'][1]);
            $pack->setContent3($packData['contents'][2]);
            $pack->setContent4($packData['contents'][3]);
            $pack->setContent5($packData['contents'][4]);
            $manager->persist($pack);
            $this->addReference('pack-' . strtolower($packData['name']), $pack);
        }

        $manager->flush();
    }
}
