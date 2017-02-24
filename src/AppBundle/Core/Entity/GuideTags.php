<?php

namespace AppBundle\Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GuideTags
 *
 * @ORM\Table(name="guide_tags")
 * @ORM\Entity(repositoryClass="AppBundle\Core\Repository\GuideTagsRepository")
 */
class GuideTags
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
     * @ORM\Column(name="tag", type="string", length=63)
     */
    private $tag;

    /**
     * @var GuideBook
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Core\Entity\GuideBook")
     * @ORM\JoinColumn(name="guide_id", referencedColumnName="id")
     */
    private $guideBook;


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
     * Set tag
     *
     * @param string $tag
     *
     * @return GuideTags
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set GuideBook
     *
     * @param GuideBook $guideBook
     *
     * @return GuideTags
     */
    public function serGuideBook($guideBook)
    {
        $this->guideBook = $guideBook;

        return $this;
    }

    /**
     * Get GuideBook
     *
     * @return GuideBook
     */
    public function getGuideBook()
    {
        return $this->guideBook;
    }
}

