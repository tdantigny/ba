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
     * @var string
     */
    private $directoryPictures;

    /**
     * GuideBook constructor.
     * @param EntityManager $entityManager
     * @param string        $directoryPictures
     */
    public function __construct(EntityManager $entityManager, string $directoryPictures)
    {
        parent::__construct($entityManager);
        $this->directoryPictures = $directoryPictures;
    }

    /**
     * Create a guide book and save the picture
     *
     * @param GuideBookEntity $guideBook
     */
    public function createdGuideBook(GuideBookEntity $guideBook)
    {
        $fileName = $this->updateFile($guideBook);

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

    /**
     * Update the picture for the guide book
     *
     * @param GuideBookEntity $guideBook
     * @return string
     */
    private function updateFile(GuideBookEntity $guideBook)
    {
        /** @var UploadedFile $file */
        $file = $guideBook->getPicture();

        // Generate a unique name for the file before saving it
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        // Move the file to the directory where brochures are stored
        $file->move(
            $this->directoryPictures,
            $fileName
        );

        return $fileName;
    }
}
