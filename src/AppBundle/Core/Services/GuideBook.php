<?php

namespace AppBundle\Core\Services;

use AppBundle\Core\Exception\CustomException;
use AppBundle\Core\Manager\Manager;
use Doctrine\ORM\EntityManager;
use AppBundle\Core\Entity\GuideBook as GuideBookEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class GuideBook
 * @package AppBundle\Core\Services
 */
class GuideBook extends Manager
{
    /**
     * @var UploadFile
     */
    private $uploadFile;

    /**
     * GuideBook constructor.
     * @param EntityManager $entityManager
     * @param UploadFile    $uploadFile
     */
    public function __construct(EntityManager $entityManager, UploadFile $uploadFile)
    {
        parent::__construct($entityManager);
        $this->uploadFile = $uploadFile;
    }

    /**
     * Create a guide book and save the picture
     *
     * @param GuideBookEntity $guideBook
     */
    public function createdGuideBook(GuideBookEntity $guideBook)
    {
        $fileName = $this->uploadFile->updateFile($guideBook->getPicture(), 'guide_book');

        $guideBook->setPicture($fileName);
        $guideBook->setHtml(html_entity_decode($guideBook->getHtml()));
        $this->getEntityManager()->persist($guideBook);
        $this->getEntityManager()->flush($guideBook);
    }

    /**
     * Enable or disable a guide book
     *
     * @param GuideBookEntity $guideBook
     * @throws CustomException
     */
    public function disabledEnabled(GuideBookEntity $guideBook)
    {
        try {
            if ($guideBook->getActive()) {
                $guideBook->setActive(false);
            } else {
                $guideBook->setActive(true);
            }

            $this->getEntityManager()->flush($guideBook);
        } catch (CustomException $customException) {
            throw new CustomException('Unable to enabled/disabled this guide book');
        }
    }

    /**
     * Remove a guide book
     *
     * @param GuideBookEntity $guideBook
     * @throws CustomException
     */
    public function delete(GuideBookEntity $guideBook)
    {
        try {
            $this->getEntityManager()->remove($guideBook);
            $this->getEntityManager()->flush();
        } catch (CustomException $customException) {
            throw new CustomException('Unable to remove this guide book');
        }
    }
}
