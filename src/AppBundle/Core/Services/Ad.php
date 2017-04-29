<?php

namespace AppBundle\Core\Services;

use AppBundle\Core\Model\AdWallpaper;
use AppBundle\Core\Manager\Manager;
use Doctrine\ORM\EntityManager;
use AppBundle\Core\Entity\Ad as AdEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Ad
 * @package AppBundle\Core\Services
 * @TODO HG : récupérer information depuis la base de données, uniquement le net actif (en fonction des dates + actif)
 */
class Ad extends Manager
{
    /**
     * @var UploadFile
     */
    private $uploadFile;

    /**
     * Ad constructor.
     * @param EntityManager $entityManager
     * @param UploadFile    $uploadFile
     */
    public function __construct(EntityManager $entityManager, UploadFile $uploadFile)
    {
        parent::__construct($entityManager);
        $this->uploadFile = $uploadFile;
    }

    /**
     * Create an ad
     *
     * @param AdEntity $ad
     */
    public function created(AdEntity $ad)
    {
        $fileName = $this->uploadFile->updateFile($ad->getPicture(), 'ad');
        $ad->setPicture($fileName);
        $this->getEntityManager()->persist($ad);
        $this->getEntityManager()->flush($ad);
    }

    public function getWallpaper()
    {
        $ad = $this->getEntityManager()->getRepository('AppBundle:Ad')
            ->getEnableWallpaper();

        if (!empty($ad) && is_array($ad)) {
            return $ad[0];
        }

        return null;
    }
}
