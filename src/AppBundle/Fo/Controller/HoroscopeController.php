<?php

namespace AppBundle\Fo\Controller;

use AppBundle\Core\Exception\CustomException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class HoroscopeController
 * @package AppBundle\Bo\Controller
 * @Route("/horoscope")
 */
class HoroscopeController extends Controller
{
    /**
     * @Route("/", name="fo_horoscope")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws CustomException
     */
    public function indexAction()
    {
        $listSign = [];
        $ad = $this->get('app_core_ad');

        try {
            foreach ($this->getParameter('url_horoscope') as $key => $value) {
                $type = $this->get('app_core_horosocope_dictionnary')->getTypeEnglishToFrench($key);
                $listSign[] = $this->get('app_core_horosocope')->getByKey($type);
            }
        } catch (CustomException $customException) {
            throw new CustomException($customException->getMessage(), 500);
        }

        return $this->render('Horoscope/index.html.twig', [
            'horoscopes' => $listSign,
            'date' => $this->get('app_core_date')->getFrenchDate(new \DateTime()),
            'adWallpaper' => $ad->getWallpaper()
        ]);
    }

    /**
     * @Route("/{type}", name="fo_horoscope_by_type")
     * @param string $type
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws CustomException
     */
    public function byTypeAction(string $type)
    {
        $ad = $this->get('app_core_ad');

        try {
            $horoscope = $this->get('app_core_horosocope')->getByKey($type);
        } catch (CustomException $customException) {
            throw new CustomException($customException->getMessage(), 500);
        }

        return $this->render('Horoscope/byType.html.twig', [
            'horoscope' => $horoscope,
            'date' => $this->get('app_core_date')->getFrenchDate(new \DateTime()),
            'adWallpaper' => $ad->getWallpaper(),
        ]);
    }
}
