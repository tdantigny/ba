<?php

namespace AppBundle\Core\Services;

use AppBundle\Core\Entity\Users;
use AppBundle\Core\Manager\Manager;
use AppBundle\Core\Entity\Yearbook;
use AppBundle\Core\Entity\VoteYearbook as VoteYearbookEntity;
use Doctrine\ORM\EntityManager;

/**
 * Class VoteYearBook
 * @package AppBundle\Core\Services
 */
class VoteYearBook extends Manager
{
    /**
     * VoteYearBook constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * Get the vote of an user about a year book
     *
     * @param Yearbook $yearbook
     * @param Users $user
     * @return VoteYearbookEntity|null
     */
    public function getByUserAndYearBook(Yearbook $yearbook, Users $user)
    {
        return $this->getEntityManager()->getRepository('AppBundle:VoteYearbook')
            ->findOneBy(
                [
                    'yearbook' => $yearbook,
                    'user' => $user,
                ]
            );
    }

    /**
     * Create or update a rate for a year book and an user
     *
     * @param Yearbook $yearbook
     * @param Users $user
     * @param int $rate
     */
    public function rate(Yearbook $yearbook, Users $user, int $rate)
    {
        $rateObject = $this->getByUserAndYearBook($yearbook, $user);
        if (!empty($rateObject)) {
            $rateObject->setRate($rate);
        } else {
            $rateObject = new VoteYearbookEntity();
            $rateObject->setYearbook($yearbook);
            $rateObject->setUser($user);
            $rateObject->setRate($rate);

            $this->getEntityManager()->persist($rateObject);
        }
        $this->getEntityManager()->flush($rateObject);
    }

    /**
     * Get the pourcentage of recommandation
     *
     * @param Yearbook $yearbook
     * @return float
     */
    public function calculateRate(Yearbook $yearbook)
    {
        $allVote = $this->getEntityManager()->getRepository('AppBundle:VoteYearbook')
            ->findBy([
                'yearbook' => $yearbook,
            ]);

        if (0 >= count($allVote)) {
            return 0.00;
        }

        $rate = 0;
        foreach ($allVote as $vote) {
            if (3 <= $vote->getRate()) {
                ++$rate;
            }
        }

        return number_format(($rate / count($allVote)) * 100, 2);
    }
}