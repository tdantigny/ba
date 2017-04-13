<?php

namespace AppBundle\Core\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Yearbook
 *
 * @ORM\Table(name="yearbook")
 * @ORM\Entity(repositoryClass="AppBundle\Core\Repository\YearbookRepository")
 */
class Yearbook
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
     * @ORM\Column(name="name", type="string", length=127, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slogan", type="string", length=255)
     */
    private $slogan;

    /**
     * @var int
     *
     * @ORM\Column(name="click", type="integer")
     */
    private $click = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var int
     *
     * @ORM\Column(name="push", type="integer", nullable=true)
     */
    private $push;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255)
     */
    private $picture;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Core\Entity\Users")
     * @ORM\JoinColumn(name="creation_user_id", referencedColumnName="id")
     */
    private $creationUser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Core\Entity\Users")
     * @ORM\JoinColumn(name="updated_user_id", referencedColumnName="id")
     */
    private $updatedUser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedDate", type="datetime")
     */
    private $updatedDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var ArrayCollection
     */
    private $paiementsMethod;

    /**
     * Yearbook constructor.
     */
    public function __construct()
    {
        $this->paiementsMethod = new ArrayCollection();
    }

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
     * @return Yearbook
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slogan
     *
     * @param string $slogan
     *
     * @return Yearbook
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;

        return $this;
    }

    /**
     * Get slogan
     *
     * @return string
     */
    public function getSlogan()
    {
        return $this->slogan;
    }

    /**
     * Set click
     *
     * @param integer $click
     *
     * @return Yearbook
     */
    public function setClick($click)
    {
        $this->click = $click;

        return $this;
    }

    /**
     * Get click
     *
     * @return int
     */
    public function getClick()
    {
        return $this->click;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Yearbook
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set push
     *
     * @param integer $push
     *
     * @return Yearbook
     */
    public function setPush($push)
    {
        $this->push = $push;

        return $this;
    }

    /**
     * Get push
     *
     * @return int
     */
    public function getPush()
    {
        return $this->push;
    }

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return Yearbook
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string|UploadedFile
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set creationUser
     *
     * @param Users $creationUser
     *
     * @return Yearbook
     */
    public function setCreationUser($creationUser)
    {
        $this->creationUser = $creationUser;

        return $this;
    }

    /**
     * Get creationUser
     *
     * @return Users
     */
    public function getCreationUser()
    {
        return $this->creationUser;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Yearbook
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set updatedUser
     *
     * @param Users $updatedUser
     *
     * @return Yearbook
     */
    public function setUpdatedUser($updatedUser)
    {
        $this->updatedUser = $updatedUser;

        return $this;
    }

    /**
     * Get updatedUser
     *
     * @return Users
     */
    public function getUpdatedUser()
    {
        return $this->updatedUser;
    }

    /**
     * Set updatedDate
     *
     * @param \DateTime $updatedDate
     *
     * @return Yearbook
     */
    public function setUpdatedDate($updatedDate)
    {
        $this->updatedDate = $updatedDate;

        return $this;
    }

    /**
     * Get updatedDate
     *
     * @return \DateTime
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Yearbook
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return ArrayCollection
     */
    public function getPaiementsMethod()
    {
        return $this->paiementsMethod;
    }

    /**
     * Set paiementsMethod
     *
     * @param ArrayCollection $paiementsMethod
     *
     * @return Yearbook
     */
    public function setPaiementsMethod($paiementsMethod)
    {
        $this->paiementsMethod = $paiementsMethod;

        return $this;
    }
}
