<?php

namespace AppBundle\Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentYearbook
 *
 * @ORM\Table(name="comment_yearbook")
 * @ORM\Entity(repositoryClass="AppBundle\Core\Repository\CommentYearbookRepository")
 */
class CommentYearbook
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
     * @var Yearbook
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Core\Entity\Yearbook")
     * @ORM\JoinColumn(name="yearbook_id", referencedColumnName="id")
     */
    private $yearbook;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;


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
     * Set yearbook
     *
     * @param Yearbook $yearbook
     *
     * @return CommentYearbook
     */
    public function setYearbook($yearbook)
    {
        $this->yearbook = $yearbook;

        return $this;
    }

    /**
     * Get yearbook
     *
     * @return Yearbook
     */
    public function getYearbook()
    {
        return $this->yearbook;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return CommentYearbook
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
}

