<?php

namespace AppBundle\Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VoteYearbook
 *
 * @ORM\Table(name="vote_yearbook")
 * @ORM\Entity(repositoryClass="AppBundle\Core\Repository\VoteYearbookRepository")
 */
class VoteYearbook
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Yearbook
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Core\Entity\Yearbook")
     * @ORM\JoinColumn(name="yearbook_id", referencedColumnName="id")
     */
    private $yearbook;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Core\Entity\Users")
     * @ORM\JoinColumn(name="users_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="rate", type="integer")
     */
    private $rate;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set yearbook
     *
     * @param Yearbook $yearbook
     *
     * @return VoteYearbook
     */
    public function setYearbook($yearbook)
    {
        $this->yearbook = $yearbook;

        return $this;
    }

    /**
     * Get yearbook
     *
     * @return Yearbook
     */
    public function getYearbook()
    {
        return $this->yearbook;
    }

    /**
     * Set user
     *
     * @param Users $user
     *
     * @return VoteYearbook
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set rate
     *
     * @param integer $rate
     *
     * @return VoteYearbook
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return int
     */
    public function getRate()
    {
        return $this->rate;
    }
}

