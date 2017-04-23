<?php

namespace AppBundle\Fo\Twig;
use AppBundle\Core\Services\User;
use AppBundle\Core\Services\VoteYearBook;
use AppBundle\Core\Services\YearBook;

/**
 * Class RateExtension
 * @package AppBundle\Fo\Twig
 */
class RateExtension extends \Twig_Extension
{
    /**
     * @var YearBook
     */
    private $serviceYearBook;

    /**
     * @var User
     */
    private $serviceUser;

    /**
     * @var VoteYearBook
     */
    private $serviceVoteYearBook;

    /**
     * RateExtension constructor.
     * @param YearBook $serviceYearBook
     * @param User $serviceUser
     * @param VoteYearBook $serviceVoteYearBook
     */
    public function __construct(YearBook $serviceYearBook, User $serviceUser, VoteYearBook $serviceVoteYearBook)
    {
        $this->serviceYearBook = $serviceYearBook;
        $this->serviceUser = $serviceUser;
        $this->serviceVoteYearBook = $serviceVoteYearBook;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_Function('getRate', array($this, 'getRate')),
            new \Twig_Function('calculateRate', array($this, 'calculateRate')),
        );
    }

    /**
     * Get the rate for an user about a year book
     *
     * @param int $yearBookId
     * @param int $userId
     * @return int
     */
    public function getRate(int $yearBookId, int $userId)
    {
        $yearBook = $this->serviceYearBook->get($yearBookId);
        $user = $this->serviceUser->get($userId);
        $rate = $this->serviceVoteYearBook->getByUserAndYearBook(
            $yearBook,
            $user
        );

        if (empty($rate)) {
            return null;
        }

        return $rate->getRate();
    }

    /**
     * Get the pourcentage of recommandation
     *
     * @param int $yearBookId
     * @return float
     */
    public function calculateRate(int $yearBookId)
    {
        $yearBook = $this->serviceYearBook->get($yearBookId);

        return $this->serviceVoteYearBook->calculateRate($yearBook);
    }
}