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
     * @var array
     */
    private $content;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $primaryPicture;

    /**
     * @var string
     */
    private $secondaryPicture;

    /**
     * @var string
     */
    private $periodStart;

    /**
     * @var string
     */
    private $periodEnd;

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
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * @param array $content
     */
    public function setContent(array $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $key
     */
    public function setName(string $name)
    {
        $this->name = $name;
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


    /**
     * @return string
     */
    public function getPeriodStart(): string
    {
        return $this->periodStart;
    }

    /**
     * @param string $periodStart
     */
    public function setPeriodStart(string $periodStart)
    {
        $this->periodStart = $periodStart;
    }

    /**
     * @return string
     */
    public function getPeriodEnd(): string
    {
        return $this->periodEnd;
    }

    /**
     * @param string $periodEnd
     */
    public function setPeriodEnd(string $periodEnd)
    {
        $this->periodEnd = $periodEnd;
    }
}