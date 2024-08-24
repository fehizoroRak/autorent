<?php

// src/Controller/PageController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/mentions-legales', name: 'app_mentions_legales')]
    public function mentionsLegales(): Response
    {
        return $this->render('legal/mentions_legales.html.twig');
    }

    #[Route('/politique-cookies', name: 'app_politique_cookies')]
    public function politiqueCookies(): Response
    {
        return $this->render('legal/politique_cookies.html.twig');
    }
    #[Route('/help', name: 'app_help')]
    public function aide(): Response
    {
        return $this->render('legal/help.html.twig');
    }
    #[Route('/faq', name: 'app_faq')]
    public function faq(): Response
    {
        return $this->render('legal/faq.html.twig');
    }
    #[Route('/contact_us', name: 'app_contact_us')]
    public function contact_us(): Response
    {
        return $this->render('legal/contact_us.html.twig');
    }
}
