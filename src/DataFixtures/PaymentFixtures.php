<?php

namespace App\DataFixtures;

use App\Entity\Payment;
use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PaymentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Retrieve all locations from the database
        $locations = $manager->getRepository(Location::class)->findAll();

        // Ensure we have enough locations to create 10 payments
        if (count($locations) < 10) {
            throw new \Exception('Not enough locations to create 10 payments.');
        }

        // Payment modes
        $paymentModes = ['Credit Card', 'Cash', 'Bank Transfer', 'PayPal'];

        // Create 10 payments with random data
        for ($i = 0; $i < 10; $i++) {
            $payment = new Payment();
            $paymentDate = new \DateTime(sprintf('-%d days', rand(1, 30)));
            $amount = rand(50, 500);
            $paymentMode = $paymentModes[array_rand($paymentModes)];

            $payment->setPaymentdate($paymentDate);
            $payment->setAmount($amount);
            $payment->setPaymentmode($paymentMode);
            $payment->setLocation($locations[array_rand($locations)]);

            $manager->persist($payment);
        }

        // Flush all payments to the database
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LocationFixtures::class,
        ];
    }
}
