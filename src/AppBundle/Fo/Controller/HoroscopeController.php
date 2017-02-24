<?php

namespace AppBundle\Fo\Controller;

use AppBundle\Core\Exception\CustomException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class HoroscopeController
 * @package AppBundle\Bo\Controller
 * @Route("/fo/horoscope")
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
        try {
            foreach ($this->getParameter('url_horoscope') as $key => $value) {
                $listSign[] = $this->get('app_core_horosocope')->getTypeEnglishToFrench($key);
            }
        } catch (CustomException $customException) {
            throw new CustomException($customException->getMessage(), 500);
        }

        return $this->render('Horoscope/index.html.twig', [
            'listSign' => $listSign,
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
        try {
            $horoscope = $this->get('app_core_horosocope')->getByType($type);
        } catch (CustomException $customException) {
            throw new CustomException($customException->getMessage(), 500);
        }

        return $this->render('Horoscope/byType.html.twig', [
            'horoscope' => $horoscope,
        ]);
    }
}
