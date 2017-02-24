<?php

namespace AppBundle\Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaiementMethod
 *
 * @ORM\Table(name="paiement_method")
 * @ORM\Entity(repositoryClass="AppBundle\Core\Repository\PaiementMethodRepository")
 */
class PaiementMethod
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

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
     * Set name
     *
     * @param string $name
     *
     * @return PaiementMethod
     */
    public function setComment($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getComment()
    {
        return $this->name;
    }
}
