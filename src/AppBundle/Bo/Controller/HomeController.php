<?php

namespace AppBundle\Bo\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class HomeController
 * @package AppBundle\Bo\Controller
 * @Route("/bo")
 * @Security("has_role('ROLE_ADMIN')")
 */
class HomeController extends Controller
{
    /**
     * @Route("/", name="bo_home")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('Home/home.html.twig');
    }
}
