<?php

namespace AppBundle\Core\Services;

use Symfony\Bundle\TwigBundle\TwigEngine;
use AppBundle\Core\Model\AdWallpaper;

/**
 * Class Ad
 * @package AppBundle\Core\Services
 * @TODO HG : récupérer information depuis la base de données, uniquement le net actif (en fonction des dates + actif)
 */
class Ad
{
    /**
     * @var AppBundle\Core\Model\AdWallpaper
     */
    private $adWallpaper;

    /**
     * Ad constructor.
     * @param TwigEngine    $twig
     * @param \Swift_Mailer $mailer
     * @param string        $mailContact
     */
    public function __construct()
    {
        $this->createFakeAdWallPaper();
    }

    /**
     * Return AdWallPaper Model
     */
    public function getAdWallpaper()
    {
        return $this->adWallpaper;
    }

    private function createFakeAdWallPaper()
    {
        $adWallPaperModel = new AdWallpaper();
        $adWallPaperModel->setImg('/bg_pub.jpg');
        $adWallPaperModel->setTitle('Tara voyance');
        $adWallPaperModel->setDateEnd('2017-03-01');
        $adWallPaperModel->setDateStart('2017-06-31');
        $adWallPaperModel->setLink('http://www.tara-voyance.com/votre-voyance-gratuite.htm');

        $this->adWallpaper = $adWallPaperModel;
    }

}
