<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        // Assume you use Symfony's security component which handles the check internally
        return $this->render('security/login.html.twig');
    }
    
    #[Route('/register', name: 'app_register')]
    public function register(): Response
    {
        // Registration logic here
        return $this->render('security/register.html.twig');
    }
    
    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
