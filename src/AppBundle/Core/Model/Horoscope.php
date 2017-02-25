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
    private $picturePrimary;

    /**
     * @var string
     */
    private $pictureSecondary;

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
    public function getPicturePrimary(): string
    {
        return $this->picturePrimary;
    }

    /**
     * @param string $picturePrimary
     */
    public function setPicturePrimary(string $picturePrimary)
    {
        $this->picturePrimary = $picturePrimary;
    }

    /**
     * @return string
     */
    public function getPictureSecondary(): string
    {
        return $this->pictureSecondary;
    }

    /**
     * @param string $pictureSecondary
     */
    public function setPictureSecondary(string $pictureSecondary)
    {
        $this->pictureSecondary = $pictureSecondary;
    }
}