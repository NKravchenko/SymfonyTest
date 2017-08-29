<?php

namespace Acme\AcmeNewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="Acme\AcmeNewsBundle\Repository\NewsRepository")
 */
class News
{

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * date of creation
     *
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * is published
     *
     * @var bool
     * @ORM\Column(name="published", type="boolean", nullable=true)
     */
    private $published;

    /**
     * short text (preview)
     *
     * @var string
     * @ORM\Column(name="text_short", type="text", nullable=true)
     */
    private $textShort;

    /**
     * full text
     *
     * @var string
     * @ORM\Column(name="text_full", type="text", nullable=true)
     */
    private $textFull;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return News
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * @param bool $published
     *
     * @return News
     */
    public function setPublished(bool $published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return string
     */
    public function getTextShort()
    {
        return $this->textShort;
    }

    /**
     * @param string $textShort
     *
     * @return News
     */
    public function setTextShort($textShort)
    {
        $this->textShort = $textShort;

        return $this;
    }

    /**
     * @return string
     */
    public function getTextFull()
    {
        return $this->textFull;
    }

    /**
     * @param string $textFull
     *
     * @return News
     */
    public function setTextFull($textFull)
    {
        $this->textFull = $textFull;

        return $this;
    }

}