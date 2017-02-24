<?php

namespace AppBundle\Core\Services;

use AppBundle\Core\Entity\Users;
use AppBundle\Core\Manager\Manager;
use Doctrine\ORM\EntityManager;

/**
 * Class User
 * @package AppBundle\Core\Services
 */
class User extends Manager
{
    /**
     * User constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * Disabled or enabled an user
     * @param Users $user
     */
    public function disabledEnabled(Users $user)
    {
        if ($user->isEnabled()) {
            $user->setEnabled(false);
        } else {
            $user->setEnabled(true);
        }

        $this->getEntityManager()->flush($user);
    }

    /**
     * @param Users $user
     */
    public function depersonalized(Users $user)
    {
        $user->setFirstName(null);
        $user->setLastName(null);
        $user->setEmail(null);
        $user->setPassword(null);
        $user->setAddress1(null);
        $user->setAddress2(null);
        $user->setCity(null);
        $user->setCivility(null);
        $user->setZipCode(null);
        $user->setPhoneNumber(null);

        $this->getEntityManager()->flush($user);
    }
}
