<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\CarRepository;
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
    public function login(Security $security, Request $request, AuthenticationUtils $authenticationUtils, CarRepository $carRepository): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Get the target path from the query parameter
        $targetPath = $request->query->get('_target_path', $this->generateUrl('app_myaccount'));

        // Initialize car, total, and user_id variables
        $car = null;
        $total = null;
         
    /** @var User|null $user */
    $user = $security->getUser();
    $userId = $user ? $user->getId() : null;

        // Only process car and total if target path is app_pack
        if ($targetPath === $this->generateUrl('app_pack')) {
            // Récupérer l'ID de la voiture et le total depuis la requête
            $carId = $request->query->get('id');
            $total = $request->query->get('total');

            // Récupérer les informations de la voiture depuis la base de données
            if ($carId) {
                $car = $carRepository->find($carId);

                // Si la voiture n'existe pas, lever une exception ou rediriger vers une autre page
                if (!$car) {
                    throw $this->createNotFoundException('The car does not exist');
                }
            }
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'car' => $car,
            'total' => $total,
            'user_id' => $userId,
            'target_path' => $targetPath, // Pass the target path to the template
        ]);
    }

    #[Route('/register', name: 'app_register')]
    public function register(CarRepository $carRepository, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
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
    
            // Add flash message
            $this->addFlash('success', 'Votre compte a bien été créé');
    
            // Redirect to the same register page to show the modal
            return $this->redirectToRoute('app_register', [
                'id' => $request->query->get('id'),
                'total' => $request->query->get('total')
            ]);
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
        // Symfony will intercept this request and handle the logout automatically
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
