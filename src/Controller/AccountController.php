<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;


class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        
        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/account/update', name: 'account_update', methods: ['POST'])]
    public function update(Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = $security->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        $user->setName($request->request->get('name'));
        $user->setFirstname($request->request->get('firstname'));
        $user->setEmail($request->request->get('email'));
        $user->setPhonenumber($request->request->get('phonenumber'));
        $user->setAddress($request->request->get('address'));

        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Vos informations ont été mises à jour avec succès.');

        return $this->redirectToRoute('account');
    }

    #[Route('/account/password', name: 'account_password')]
    public function password(Security $security): Response
    {
        $user = $security->getUser();
        
        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('account/password.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/account/password/update', name: 'account_password_update', methods: ['POST'])]
    public function updatePassword(Request $request, Security $security, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $security->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        $oldPassword = $request->request->get('old_password');
        $newPassword = $request->request->get('new_password');

        // Validate the old password
        if (!$passwordHasher->isPasswordValid($user, $oldPassword)) {
            $this->addFlash('error', 'L\'ancien mot de passe est incorrect.');
            return $this->redirectToRoute('account_password');
        }

        // Encode the new password
        $encodedPassword = $passwordHasher->hashPassword($user, $newPassword);
        $user->setPassword($encodedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Votre mot de passe a été mis à jour avec succès.');

        return $this->redirectToRoute('account_password');
    }
}