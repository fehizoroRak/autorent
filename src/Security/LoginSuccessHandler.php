<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $token->getUser();
     

        // Récupérer la valeur de _target_path depuis la requête
        $targetPath = $request->get('_target_path');
        //dd($targetPath);
        // Si l'utilisateur a le rôle ROLE_ADMIN et que le _target_path est /pack
        if (in_array('ROLE_ADMIN', $user->getRoles()) && $targetPath === $this->router->generate('app_pack')) {
            // Rediriger vers app_pack
            return new RedirectResponse($this->router->generate('app_pack'));
        }

        // Si l'utilisateur est admin mais qu'il n'est pas censé aller vers /pack, rediriger vers app_home
        if (in_array('ROLE_ADMIN', $user->getRoles()) && $targetPath === $this->router->generate('app_myaccount')) {
            return new RedirectResponse($this->router->generate('app_home'));
        }

        // Pour les autres utilisateurs, rediriger vers le target path ou la page par défaut
        if ($targetPath) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->router->generate('app_myaccount'));
    }
}
