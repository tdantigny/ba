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
     * @return Response
     */
    public function indexAction()
    {
        $this->get('login_success_handler');

        $guideBook = $this->get('app_core_guide_book')->getRandomOne();
        $ad = $this->get('app_core_ad');

        //We check if the current user is connected
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            //If he is connected, we are looking for is own horoscope
            $tokenSession = $this->get('security.token_storage')->getToken();
            $horoscope = $this->get('app_core_horosocope')->getByBirthDate(
                $tokenSession->getUser()->getBirthDate()
            );
        } else {
            //Else we take a random horoscope
            $horoscope = $this->get('app_core_horosocope')->getRandomOne();
        }

        return $this->render('Home/index.html.twig',
            [
                'guideBook' => $guideBook,
                'horoscope' => $horoscope,
                'adWallpaper' => $ad->getAdWallpaper()
            ]
        );
    }
}
