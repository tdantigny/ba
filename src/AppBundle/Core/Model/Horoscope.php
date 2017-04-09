<?php

namespace AppBundle\Core\Model;

/**
 * Class Horoscope
 * @package AppBundle\Core\Model
 */
class Horoscope
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $primaryPicture;

    /**
     * @var string
     */
    private $secondaryPicture;

    /**
     * Horoscope constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getPrimaryPicture(): string
    {
        return $this->primaryPicture;
    }

    /**
     * @param string $primaryPicture
     */
    public function setPrimaryPicture(string $primaryPicture)
    {
        $this->primaryPicture = $primaryPicture;
    }

    /**
     * @return string
     */
    public function getSecondaryPicture(): string
    {
        return $this->secondaryPicture;
    }

    /**
     * @param string $secondaryPicture
     */
    public function setSecondaryPicture(string $secondaryPicture)
    {
        $this->secondaryPicture = $secondaryPicture;
    }
}