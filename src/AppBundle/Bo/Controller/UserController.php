<?php

namespace AppBundle\Bo\Controller;

use AppBundle\Bo\Form\UserFilterType;
use AppBundle\Bo\Form\UserModifyType;
use AppBundle\Core\Entity\Users;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController
 * @package AppBundle\Bo\Controller
 * @Route("/bo/utilisateur")
 * @Security("has_role('ROLE_ADMIN')")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="bo_user_list")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Users')
            ->createQueryBuilder('u');

        $form = $this->get('form.factory')->create(UserFilterType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
        }

        $query = $filterBuilder->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            10
        );

        return $this->render('User/index.html.twig', [
            'form' => $form->createView(),
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/detail/{user}", name="bo_user_detail")
     * @param Request $request
     * @param Users   $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailAction(Request $request, Users $user)
    {
        $form = $this->get('form.factory')->create(UserModifyType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush($user);
        }

        return $this->render('User/detail.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/enabled/{user}", name="bo_user_enabled", options={"expose"=true})
     * @param Users $user
     * @return Response
     */
    public function changeEnabledAction(Users $user)
    {
        if ($user->getId() !== $this->get('security.token_storage')->getToken()->getUser()->getId()) {
            $this->get('app_core_user')->disabledEnabled($user);

            return new Response('Ok', 200);
        }

        return new Response('Ok', 500);
    }

    /**
     * @Route("/depersonalize/{user}", name="bo_user_depersonalize", options={"expose"=true})
     * @param Users $user
     * @return Response
     */
    public function depersonalizeAction(Users $user)
    {
        $this->get('app_core_user')->disabledEnabled($user);
        $this->get('app_core_user')->depersonalized($user);

        return new Response('Ok', 200);
    }
}
