<?php

namespace AppBundle\Core\Services;

use AppBundle\Core\Exception\CustomException;
use AppBundle\Core\Manager\Manager;
use Doctrine\ORM\EntityManager;
use AppBundle\Core\Entity\PaiementMethod as PaiementMethodEntity;

/**
 * Class PaiementMethod
 * @package AppBundle\Core\Services
 */
class PaiementMethod extends Manager
{
    /**
     * PaiementMethod constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * Create a paiement method
     *
     * @param PaiementMethodEntity $paiementMethod
     */
    public function created(PaiementMethodEntity $paiementMethod)
    {
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
