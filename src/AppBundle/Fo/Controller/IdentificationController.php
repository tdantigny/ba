<?php

namespace AppBundle\Fo\Controller;

use FOS\UserBundle\Controller\SecurityController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class IdentificationController
 * @package AppBundle\Controller
 */
class IdentificationController extends SecurityController
{
    /**
     * @Route("/login", name="fo_login")
     * @param Request $request
     *
     * @return Response|RedirectResponse
     */
    public function loginAction(Request $request)
    {
        $authChecker = $this->get('security.authorization_checker');
        $router = $this->get('router');

        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse($router->generate('bo_home'), 307);
        }

        $this->get('security.authorization_checker');

        if ($authChecker->isGranted('ROLE_USER')) {
            return new RedirectResponse($router->generate('fo_home'), 307);
        }

        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null;
        }

        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        return $this->render('Identification/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ]);
    }
}
