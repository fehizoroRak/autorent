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
        $user = $token->getUser();
        $targetPath = $request->get('_target_path');

        if ($targetPath === $this->router->generate('app_pack')) {
            $carId = $request->query->get('id');
            $total = $request->query->get('total');

            if ($carId && $total) {
                return new RedirectResponse($this->router->generate('app_pack', [
                    'id' => $carId,
                    'total' => $total
                ]));
            }
        }

        // Vérifier si l'utilisateur est un admin
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            if ($targetPath === $this->router->generate('app_pack')) {
                return new RedirectResponse($this->router->generate('app_pack'));
            }

            // Redirection pour les admins non concernés par app_pack
            return new RedirectResponse($this->router->generate('app_home'));
        }

        // Autres redirections selon le rôle de l'utilisateur
        if ($targetPath) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->router->generate('app_myaccount'));
    }
}
