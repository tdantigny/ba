<?php

namespace AppBundle\Core\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class GuideBook
 * @package AppBundle\Core\Model
 */
class GuideBook
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var bool
     */
    private $enable;

    /**
     * @var ArrayCollection
     */
    private $paragraphs;

    /**
     * @var string
     */
    private $picture;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
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
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->enable;
    }

    /**
     * @param bool $enable
     */
    public function setEnable(bool $enable)
    {
        $this->enable = $enable;
    }

    /**
     * @return ArrayCollection
     */
    public function getParagraphs(): ArrayCollection
    {
        return $this->paragraphs;
    }

    /**
     * @param ArrayCollection $paragraphs
     */
    public function setParagraphs(ArrayCollection $paragraphs)
    {
        $this->paragraphs = $paragraphs;
    }

    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture(string $picture)
    {
        $this->picture = $picture;
    }
}