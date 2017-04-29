<?php

namespace AppBundle\Core\Model;

/**
 * Class GuideBookParagraph
 * @package AppBundle\Core\Model
 */
class GuideBookParagraph
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $picture;

    /**
     * @var string
     */
    private $picturePosition;

    /**
     * @var string
     */
    private $title;

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

    /**
     * @return string
     */
    public function getPicturePosition(): string
    {
        return $this->picturePosition;
    }

    /**
     * @param string $picturePosition
     */
    public function setPicturePosition(string $picturePosition)
    {
        $this->picturePosition = $picturePosition;
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
}