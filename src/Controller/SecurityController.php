<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(Request $request, UserRepository $userRepository, CarRepository $carRepository, AuthenticationUtils $authenticationUtils, Security $security): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Récupérer l'ID de la voiture et le total depuis la requête
        $carId = $request->query->get('id');
        $total = $request->query->get('total');

        // Récupérer les informations de la voiture depuis la base de données
        $car = $carRepository->find($carId);

        // Si la voiture n'existe pas, lever une exception ou rediriger vers une autre page
        if (!$car) {
            throw $this->createNotFoundException('The car does not exist');
        }

        // Récupérer l'utilisateur connecté

         /** @var User|null $user */
        $user = $security->getUser();
        $userId = null;

        if ($user) {
            $userId = $user->getId(); // Suppose que votre entité User a une méthode getId()
        }

        $user = $userRepository->find($userId);
      

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'car' => $car,
            'total' => $total,
            'user' => $user,
        ]);
    }
    
    
    #[Route('/register', name: 'app_register')]
    public function register(CarRepository $carRepository,Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Hash the plain password
            $user->setPassword($passwordHasher->hashPassword(
                $user,
                $form->get('password')->getData()
            ));
            
          // Set default role
            $user->setRoles(['ROLE_USER']);

            $entityManager->persist($user);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_login');
        }
        $carId = $request->query->get('id');
        $total = $request->query->get('total');

        // Récupérer les informations de la voiture depuis la base de données
        $car = $carRepository->find($carId);

        // Si la voiture n'existe pas, lever une exception ou rediriger vers une autre page
        if (!$car) {
            throw $this->createNotFoundException('The car does not exist');
        }
    
        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
            'car' => $car,
            'total' => $total,
        ]);
    }
    
    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
