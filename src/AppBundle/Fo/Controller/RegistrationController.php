<?php

namespace AppBundle\Fo\Controller;

use AppBundle\Core\Entity\Users;
use AppBundle\Fo\Form\RegistrationType;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;

/**
 * Class RegistrationController
 * @package AppBundle\Controller
 */
class RegistrationController extends BaseController
{
    /**
     * @Route("/inscription", name="fo_register")
     * @param Request $request
     *
     * @return Response|RedirectResponse
     */
    public function registerAction(Request $request)
    {
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = new Users();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->createForm(RegistrationType::class, $user);
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $existUser = $this->get('app_core_user')->existUserNewsletter(
                $user->getEmail()
            );
            if ($form->isValid()
                && !$existUser
            ) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
                $user->setUsername($user->getEmail());
                $encoder = $this->get('security.password_encoder');
                $encoded = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($encoded);
                $user->setCreationDate(new \DateTime());
                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fo_home');
                    $request->getSession()
                        ->getFlashBag()
                        ->add('success', 'Inscription effectuée avec succès');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            if ($form->isValid()
                && $existUser
            ) {
                $userService = $this->get('app_core_user');
                $userRegister = $userService->getUserNewsletter(
                    $user->getEmail()
                );
                $userRegisterUpdate = $this->get('app_core_user')->switchUserData(
                    $userRegister,
                    $user
                );
                $this->getDoctrine()->getManager()
                    ->flush($userRegisterUpdate);
                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fo_home');
                    $request->getSession()
                        ->getFlashBag()
                        ->add('success', 'Inscription effectuée avec succès')
                    ;
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($userRegisterUpdate, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('Registration/register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
