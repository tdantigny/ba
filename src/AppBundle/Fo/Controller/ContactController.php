<?php

namespace AppBundle\Fo\Controller;

use AppBundle\Fo\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class ContactController
 * @package AppBundle\Fo\Controller
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     * @Route("/", name="fo_contact")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function previewAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app_core_contact')->sendMail(
                $form->getData()
            );
        }

        return $this->render(
            'Contact/index.html.twig',
            [
                'formulaire' => $form->createView(),
            ]
        );
    }
}
