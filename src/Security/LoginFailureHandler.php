<?php
// src/Security/LoginFailureHandler.php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class LoginFailureHandler implements AuthenticationFailureHandlerInterface
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        // Récupère tous les paramètres GET actuels
        $queryParams = $request->query->all();

        // Reconstruit l'URL de connexion avec les paramètres GET
        $url = $this->router->generate('app_login', $queryParams);

        // Redirige vers l'URL avec les paramètres GET conservés
        return new RedirectResponse($url);
    }
}
