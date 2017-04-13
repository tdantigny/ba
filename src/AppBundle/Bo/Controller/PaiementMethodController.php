<?php

namespace AppBundle\Bo\Controller;

use AppBundle\Bo\Form\PaiementMethodFilterType;
use AppBundle\Bo\Form\PaiementMethodType;
use AppBundle\Core\Entity\PaiementMethod;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PaiementMethodController
 * @package AppBundle\Bo\Controller
 * @Route("/bo/paiement-method")
 * @Security("has_role('ROLE_ADMIN')")
 */
class PaiementMethodController extends Controller
{
    /**
     * @Route("/", name="bo_paiement_method_list")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:PaiementMethod')
            ->createQueryBuilder('pm');

        $form = $this->get('form.factory')->create(PaiementMethodFilterType::class);

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

        return $this->render('PaiementMethod/index.html.twig', [
            'form' => $form->createView(),
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/add", name="bo_paiement_method_add")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $paiementMethod = new PaiementMethod();
        $form = $this->get('form.factory')->create(PaiementMethodType::class, $paiementMethod);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app_core_paiement_method')->created($paiementMethod);
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Le moyen de paiement à été crée avec succès');

            return $this->redirectToRoute('bo_paiement_method_list');
        }

        return $this->render('PaiementMethod/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/detail/{paiementMethod}", name="bo_paiement_method_detail")
     * @param Request        $request
     * @param PaiementMethod $paiementMethod
     * @return Response
     */
    public function detailAction(Request $request, PaiementMethod $paiementMethod)
    {
        $directoryPictures = $this->getParameter('directory_pictures');
        $file = new File($directoryPictures['paiement_method'].$paiementMethod->getPicture());
        $paiementMethod->setPicture($file);
        $form = $this->get('form.factory')->create(PaiementMethodType::class, $paiementMethod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app_core_paiement_method')->update($paiementMethod);
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Le moyen de paiement à été modifié avec succès');

            return $this->redirectToRoute('bo_paiement_method_list');
        }

        return $this->render('PaiementMethod/detail.html.twig', [
            'form' => $form->createView(),
            'paiementMethod' => $paiementMethod,
        ]);
    }
}
