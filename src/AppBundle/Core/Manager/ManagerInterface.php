<?php

namespace AppBundle\Core\Manager;

use Doctrine\ORM\EntityManager;

/**
 * Interface ManagerInterface
 * @package AppBundle\Core\Services
 */
interface ManagerInterface
{
    /**
     * @return EntityManager
     */
    public function getEntityManager();
}