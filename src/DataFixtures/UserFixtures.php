<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        // Create an array of user data
        $usersData = [
            [
                'name' => 'Doe',
                'firstname' => 'John',
                'email' => 'john.doe@example.com',
                'phonenumber' => '1234567890',
                'address' => '123 Main St',
                'password' => '1234',
                'roles' => ['ROLE_USER']
            ],
            [
                'name' => 'Smith',
                'firstname' => 'Jane',
                'email' => 'jane.smith@example.com',
                'phonenumber' => '0987654321',
                'address' => '456 Elm St',
                'password' => '1234',
                'roles' => ['ROLE_USER']
            ],
            [
                'name' => 'Brown',
                'firstname' => 'Charlie',
                'email' => 'charlie.brown@example.com',
                'phonenumber' => '1122334455',
                'address' => '789 Oak St',
                'password' => '1234',
                'roles' => ['ROLE_USER']
            ],
            [
                'name' => 'Johnson',
                'firstname' => 'Chris',
                'email' => 'chris.johnson@example.com',
                'phonenumber' => '2233445566',
                'address' => '101 Pine St',
                'password' => '1234',
                'roles' => ['ROLE_USER']
            ],
            [
                'name' => 'Williams',
                'firstname' => 'Pat',
                'email' => 'pat.williams@example.com',
                'phonenumber' => '3344556677',
                'address' => '202 Cedar St',
                'password' => '1234',
                'roles' => ['ROLE_USER']
            ],
            [
                'name' => 'Jones',
                'firstname' => 'Alex',
                'email' => 'alex.jones@example.com',
                'phonenumber' => '4455667788',
                'address' => '303 Birch St',
                'password' => '1234',
                'roles' => ['ROLE_USER']
            ],
            [
                'name' => 'Garcia',
                'firstname' => 'Taylor',
                'email' => 'taylor.garcia@example.com',
                'phonenumber' => '5566778899',
                'address' => '404 Spruce St',
                'password' => '1234',
                'roles' => ['ROLE_USER']
            ],
            [
                'name' => 'Miller',
                'firstname' => 'Jordan',
                'email' => 'jordan.miller@example.com',
                'phonenumber' => '6677889900',
                'address' => '505 Maple St',
                'password' => '1234',
                'roles' => ['ROLE_USER']
            ],
            [
                'name' => 'Davis',
                'firstname' => 'Morgan',
                'email' => 'morgan.davis@example.com',
                'phonenumber' => '7788990011',
                'address' => '606 Willow St',
                'password' => '1234',
                'roles' => ['ROLE_USER']
            ],
            [
                'name' => 'Rodriguez',
                'firstname' => 'Casey',
                'email' => 'casey.rodriguez@example.com',
                'phonenumber' => '8899001122',
                'address' => '707 Aspen St',
                'password' => '1234',
                'roles' => ['ROLE_USER']
            ],
        ];

        // Create and persist each user
        foreach ($usersData as $userData) {
            $user = new User();
            $user->setName($userData['name']);
            $user->setFirstname($userData['firstname']);
            $user->setEmail($userData['email']);
            $user->setPhonenumber($userData['phonenumber']);
            $user->setAddress($userData['address']);
            $user->setRoles($userData['roles']);
            // Hash the password
            $hashedPassword = $this->passwordHasher->hashPassword($user, $userData['password']);
            $user->setPassword($hashedPassword);
            $manager->persist($user);
        }

        // Flush all users to the database
        $manager->flush();
    }
}
