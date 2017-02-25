<?php

namespace AppBundle\Fo\Controller;

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
 * @package AppBundle\Fo\Controller
 * @Route("/guide")
 * @Security("has_role('ROLE_ADMIN')")
 */
class GuideBookController extends Controller
{
    /**
     * @Route("/{guideBook}/{title}", name="fo_guide_book")
     * @param GuideBook $guideBook
     * @param string    $title
     * @return Response
     */
    public function previewAction(GuideBook $guideBook, string $title)
    {
        unset($title);
        $guideBook->setHtml(html_entity_decode($guideBook->getHtml()));

        return $this->render('GuideBook/preview.html.twig', [
            'guideBook' => $guideBook,
        ]);
    }
}
