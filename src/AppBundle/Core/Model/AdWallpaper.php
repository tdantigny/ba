<?php

namespace AppBundle\Core\Model;

/**
 * Class AdWallpaper
 * @package AppBundle\Core\Model
 */
class AdWallpaper
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $img;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $dateStart;

    /**
     * @var string
     */
    private $dateEnd;

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
     * @return string
     */
    public function getImg(): string
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg(string $img)
    {
        $this->img = $img;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link)
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getDateStart(): string
    {
        return $this->dateStart;
    }

    /**
     * @param string $dateStart
     */
    public function setDateStart(string $dateStart)
    {
        $this->dateStart = $dateStart;
    }

    /**
     * @return string
     */
    public function getDateEnd(): string
    {
        return $this->dateEnd;
    }

    /**
     * @param string $dateEnd
     */
    public function setDateEnd(string $dateEnd)
    {
        $this->dateEnd = $dateEnd;
    }



}