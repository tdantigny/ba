<?php

namespace AppBundle\Fo\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 * @package AppBundle\Fo\Controller
 */
class HomeController extends Controller
{
    /**
     * @Route("/", name="fo_home")
     * @Method({"GET"})
     * @param string $name
     * @return Response
     */
    public function indexAction()
    {
        $this->get('login_success_handler');

        return $this->render('Home/index.html.twig');
    }
}
