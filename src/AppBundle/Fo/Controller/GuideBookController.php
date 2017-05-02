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
 */
class GuideBookController extends Controller
{
    /**
     * @Route("/", name="fo_guidebooks")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws CustomException
     */
    public function indexAction()
    {
        $guideBook = $this->get('app_core_guide_book');

        return $this->render('GuideBook/index.html.twig', [
            'guidebooks' => $guideBook->getAll(),
        ]);
    }
    /**
     * @Route("/{id}-{title}", name="fo_guidebook")
     * @param int       $id
     * @param string    $title
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws CustomException
     */
    public function byNameAction(GuideBook $guideBook, int $id, string $title)
    {
        $guideBook = $this->get('app_core_guide_book');

        return $this->render('GuideBook/byId.html.twig', [
            'guidebook' => $guideBook->get($id),
        ]);
    }
}
