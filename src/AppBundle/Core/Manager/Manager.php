<?php
/**
 * Created by PhpStorm.
 * User: tegbessou
 * Date: 24/11/2016
 * Time: 21:24
 */

namespace AppBundle\Core\Manager;


use Doctrine\ORM\EntityManager;

/**
 * Class Manager
 * @package AppBundle\Core\Manager
 */
class Manager implements ManagerInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Manager constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }
}