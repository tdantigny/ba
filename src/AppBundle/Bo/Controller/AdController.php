<?php

namespace AppBundle\Bo\Controller;

use AppBundle\Bo\Form\AdFilterType;
use AppBundle\Bo\Form\AdType;
use AppBundle\Bo\Form\PaiementMethodFilterType;
use AppBundle\Bo\Form\PaiementMethodType;
use AppBundle\Core\Entity\Ad;
use AppBundle\Core\Entity\PaiementMethod;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdController
 * @package AppBundle\Bo\Controller
 * @Route("/bo/ad")
 * @Security("has_role('ROLE_ADMIN')")
 */
class AdController extends Controller
{
    /**
     * @Route("/", name="bo_ad_list")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Ad')
            ->createQueryBuilder('ad');

        $form = $this->get('form.factory')->create(AdFilterType::class);

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

        return $this->render('Ad/index.html.twig', [
            'form' => $form->createView(),
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/add", name="bo_ad_add")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $ad = new Ad();
        $form = $this->get('form.factory')->create(AdType::class, $ad);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app_core_ad')->created($ad);
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'La pub à été créée avec succès');

            return $this->redirectToRoute('bo_ad_list');
        }

        return $this->render('PaiementMethod/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/detail/{ad}", name="bo_ad_detail")
     * @param Request $request
     * @param Ad      $ad
     * @return Response
     */
    public function detailAction(Request $request, Ad $ad)
    {
        $directoryPictures = $this->getParameter('directory_pictures');
        $file = new File($directoryPictures['ad'].$ad->getPicture());
        $ad->setPicture($file);
        $form = $this->get('form.factory')->create(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app_core_paiement_method')->update($ad);
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Le moyen de paiement à été modifié avec succès');

            return $this->redirectToRoute('bo_ad_list');
        }

        return $this->render('Ad/detail.html.twig', [
            'form' => $form->createView(),
            'paiementMethod' => $ad,
        ]);
    }
}
