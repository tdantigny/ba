<?php

namespace AppBundle\Fo\Controller;

use AppBundle\Core\Entity\Users;
use AppBundle\Fo\Form\NewsletterType;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class ContactController
 * @package AppBundle\Fo\Controller
 * @Route("/newsletter")
 */
class NewsletterController extends Controller
{
    /**
     * @Route("/{fromAjax}", name="fo_newsletter", options={"expose"=true})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param bool    $fromAjax
     * @return Response
     */
    public function indexAction(Request $request, bool $fromAjax = false)
    {
        $user = new Users();
        $form = $this->createForm(
            NewsletterType::class,
            $user

        );

        if ($fromAjax) {
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Inscription prise en compte');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->get('app_core_user')->existUser($user->getEmail())) {
                /** @var $userManager UserManagerInterface */
                $userManager = $this->get('fos_user.user_manager');
                $user->setEnabled(false);
                $user->setPassword('toto');
                $user->setEnableNewsletter(true);
                $user->setUsername($user->getEmail());
                $user->setCreationDate(new \DateTime());
                $userManager->updateUser($user);

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Inscription prise en compte');
            } else {
                $request->getSession()
                    ->getFlashBag()
                    ->add('error', 'Vous êtes déjà inscrit à notre newsletter');
            }
        }

        return $this->render(
            'Newsletter/index.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/", name="fo_newsletter_register", options={"expose"=true})
     * @Method({"GET"})
     * @param Request $request
     * @return Response
     */
    public function registerNewsletterAjax(Request $request)
    {
        /** @var Users $user */
        $user = $this->get('security.token_storage')->getToken()
            ->getUser();
        $user->setEnableNewsletter(true);
        $this->getDoctrine()->getManager()
            ->flush($user);

        return new Response('OK', 200);
    }
}
