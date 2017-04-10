<?php

namespace AppBundle\Core\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email", column=@ORM\Column(type="string", name="email", length=255, unique=false, nullable=true)),
 *      @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(type="string", name="email_canonical", length=255, unique=false, nullable=true))
 * })
 */
class Users extends BaseUser
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=63)
     */
    private $lastName;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=63)
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(name="zip_code", type="string", length=5)
     */
    private $zipCode;

    /**
     * @var string
     * @ORM\Column(name="city", type="string", length=65, nullable=true)
     */
    private $city;

    /**
     * @var string
     * @ORM\Column(name="civility", type="string", length=5, nullable=true)
     */
    private $civility;

    /**
     * @var string
     * @ORM\Column(name="phone_number", type="string", length=10, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var \DateTime
     * @ORM\Column(name="birth_date", type="date")
     */
    private $birthDate;

    /**
     * @var string
     * @ORM\Column(name="address1", type="string", length=100, nullable=true)
     */
    private $address1;

    /**
     * @var string
     * @ORM\Column(name="address2", type="string", length=100, nullable=true)
     */
    private $address2;

    /**
     * @var bool
     * @ORM\Column(name="enable_newsletter", type="boolean")
     */
    private $enableNewsletter = false;

    /**
     * @var \DateTime
     * @ORM\Column(name="creation_date", type="date")
     */
    private $creationDate;

    /**
     * Users constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setCreationDate(new \DateTime());
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCivility()
    {
        return $this->civility;
    }

    /**
     * @param string $civility
     */
    public function setCivility($civility)
    {
        $this->civility = $civility;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param string $address1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param string $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * @return boolean
     */
    public function isEnableNewsletter()
    {
        return $this->enableNewsletter;
    }

    /**
     * @param boolean $enableNewsletter
     */
    public function setEnableNewsletter($enableNewsletter)
    {
        $this->enableNewsletter = $enableNewsletter;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }
}
