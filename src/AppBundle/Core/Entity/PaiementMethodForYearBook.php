<?php

namespace AppBundle\Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaiementMethodForYearBook
 *
 * @ORM\Table(name="paiement_method_for_year_book")
 * @ORM\Entity(repositoryClass="AppBundle\Core\Repository\PaiementMethodForYearBookRepository")
 */
class PaiementMethodForYearBook
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Core\Entity\Yearbook", inversedBy="paiementsMethod")
     * @ORM\JoinColumn(name="yearbook_id", referencedColumnName="id")
     */
    private $yearbook;

    /**
     * @var PaiementMethod
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Core\Entity\PaiementMethod")
     * @ORM\JoinColumn(name="paiement_method_id", referencedColumnName="id")
     */
    private $paiementMethod;

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
     * @return PaiementMethodForYearBook
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
     * @param PaiementMethod $paiementMethod
     *
     * @return PaiementMethodForYearBook
     */
    public function setPaiementMethod($paiementMethod)
    {
        $this->paiementMethod = $paiementMethod;

        return $this;
    }

    /**
     * Get user
     *
     * @return PaiementMethod
     */
    public function getPaiementMethod()
    {
        return $this->paiementMethod;
    }
}
