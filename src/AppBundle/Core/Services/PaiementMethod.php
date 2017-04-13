<?php

namespace AppBundle\Core\Services;

use AppBundle\Core\Exception\CustomException;
use AppBundle\Core\Manager\Manager;
use Doctrine\ORM\EntityManager;
use AppBundle\Core\Entity\PaiementMethod as PaiementMethodEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class PaiementMethod
 * @package AppBundle\Core\Services
 */
class PaiementMethod extends Manager
{
    /**
     * @var UploadFile
     */
    private $uploadFile;

    /**
     * PaiementMethod constructor.
     * @param EntityManager $entityManager
     * @param UploadFile    $uploadFile
     */
    public function __construct(EntityManager $entityManager, UploadFile $uploadFile)
    {
        parent::__construct($entityManager);
        $this->uploadFile = $uploadFile;
    }

    /**
     * Create a paiement method
     *
     * @param PaiementMethodEntity $paiementMethod
     */
    public function created(PaiementMethodEntity $paiementMethod)
    {
        $fileName = $this->uploadFile->updateFile($paiementMethod->getPicture(), 'paiement_method');
        $paiementMethod->setPicture($fileName);
        $this->getEntityManager()->persist($paiementMethod);
        $this->getEntityManager()->flush($paiementMethod);
    }

    /**
     * Upadate a paiement method
     *
     * @param PaiementMethodEntity $paiementMethod
     */
    public function update(PaiementMethodEntity $paiementMethod)
    {
        $this->getEntityManager()->flush($paiementMethod);
    }

    /**
     * Remove a paiement method
     *
     * @param PaiementMethodEntity $paiementMethod
     * @throws CustomException
     */
    public function delete(PaiementMethodEntity $paiementMethod)
    {
        try {
            $this->getEntityManager()->remove($paiementMethod);
            $this->getEntityManager()->flush();
        } catch (CustomException $customException) {
            throw new CustomException('Unable to remove this guide book');
        }
    }
}
