<?php

namespace AppBundle\Bo\Controller;

use AppBundle\Bo\Form\YearBookFilterType;
use AppBundle\Core\Entity\Yearbook;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GuideBookController
 * @package AppBundle\Bo\Controller
 * @Route("/bo/annuaire")
 * @Security("has_role('ROLE_ADMIN')")
 */
class YearBookController extends Controller
{
    /**
     * @Route("/", name="bo_year_book_list", options={"expose"=true})
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Yearbook')
            ->createQueryBuilder('yb');

        $form = $this->get('form.factory')->create(YearBookFilterType::class);

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

        return $this->render('YearBook/index.html.twig', [
            'form' => $form->createView(),
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/add", name="bo_year_book_add")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        return new Response('Ajouter');
    }

    /**
     * @Route("/detail/{id}", name="bo_year_book_detail")
     * @param Request  $request
     * @param Yearbook $yearbook
     * @return Response
     */
    public function detailAction(Request $request, Yearbook $yearbook)
    {
        dump($yearbook);

        return new Response('Modifier');
    }
}
