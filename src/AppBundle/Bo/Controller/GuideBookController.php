<?php

namespace AppBundle\Bo\Controller;

use AppBundle\Bo\Form\GuideBookFilterType;
use AppBundle\Bo\Form\GuideBookType;
use AppBundle\Core\Entity\GuideBook;
use AppBundle\Core\Exception\CustomException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GuideBookController
 * @package AppBundle\Bo\Controller
 * @Route("/bo/guide")
 * @Security("has_role('ROLE_ADMIN')")
 */
class GuideBookController extends Controller
{
    /**
     * @Route("/", name="bo_guide_book_list", options={"expose"=true})
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:GuideBook')
            ->createQueryBuilder('gb');

        $form = $this->get('form.factory')->create(GuideBookFilterType::class);

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

        return $this->render('GuideBook/index.html.twig', [
            'form' => $form->createView(),
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/add", name="bo_guide_book_add")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $guideBook = new GuideBook();
        $form = $this->get('form.factory')->create(GuideBookType::class, $guideBook);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app_core_guide_book')->createdGuideBook($guideBook);
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Le guide à été crée avec succès');

            return $this->redirectToRoute('bo_guide_book_list');
        }

        return $this->render('GuideBook/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/detail/{guideBook}", name="bo_guide_book_detail")
     * @param Request   $request
     * @param GuideBook $guideBook
     * @return Response
     */
    public function detailAction(Request $request, GuideBook $guideBook)
    {
        $directoryPictures = $this->getParameter('directory_pictures');
        $file = new File($directoryPictures['guide_book'].$guideBook->getPicture());
        $guideBook->setPicture($file);
        $form = $this->get('form.factory')->create(GuideBookType::class, $guideBook);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            die();
            //$this->get('app_core_guide_book')->createdGuideBook($guideBook);
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Le guide à été modifié avec succès');

            return $this->redirectToRoute('bo_guide_book_list');
        }

        return $this->render('GuideBook/detail.html.twig', [
            'form' => $form->createView(),
            'guideBook' => $guideBook,
        ]);
    }

    /**
     * @Route("/previsualisation/{guideBook}", name="bo_guide_book_preview")
     * @param Request   $request
     * @param GuideBook $guideBook
     * @return Response
     */
    public function previewAction(Request $request, GuideBook $guideBook)
    {
        $guideBook->setHtml(html_entity_decode($guideBook->getHtml()));

        return $this->render('GuideBook/preview.html.twig', [
            'guideBook' => $guideBook,
        ]);
    }

    /**
     * @Route("/enabled/{guideBook}", name="bo_guide_book_enabled", options={"expose"=true})
     * @param GuideBook $guideBook
     * @return Response
     */
    public function changeEnabledAction(GuideBook $guideBook)
    {
        try {
            $this->get('app_core_guide_book')->disabledEnabled($guideBook);
        } catch (CustomException $customException) {
            return new Response($customException->getMessage());
        }

        return new Response('OK', 200);
    }

    /**
     * @Route("/delete/{guideBook}", name="bo_guide_book_delete", options={"expose"=true})
     * @param GuideBook $guideBook
     * @return Response
     */
    public function deleteAction(GuideBook $guideBook)
    {
        try {
            $this->get('app_core_guide_book')->delete($guideBook);
        } catch (CustomException $customException) {
            return new Response($customException->getMessage());
        }

        return new Response('OK', 200);
    }
}
