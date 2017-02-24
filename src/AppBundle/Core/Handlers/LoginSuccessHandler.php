<?php

namespace AppBundle\Core\Handlers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

/**
 * Class LoginSuccessHandler
 * @package AppBundle\Core\Handlers
 */
class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{

    protected $router;
    protected $security;

    /**
     * LoginSuccessHandler constructor.
     * @param Router                        $router
     * @param AuthorizationCheckerInterface $security
     */
    public function __construct(Router $router, AuthorizationCheckerInterface $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    /**
     * @param Request        $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $response = new Response();
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $response = new RedirectResponse($this->router->generate('bo_home'));
        } elseif ($this->security->isGranted('ROLE_USER')) {
            // redirect the user to where they were before the login process begun.
            $refererUrl = $request->headers->get('referer');
            $response = new RedirectResponse($refererUrl);
        }

        return $response;
    }

}