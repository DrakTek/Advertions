<?php

namespace Drak\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Advert
 *
 * @ORM\Table("drk_advert")
 * @ORM\Entity(repositoryClass="Drak\BlogBundle\Entity\AdvertRepository")
 */
class Advert
{
    public function __construct()
    {
        $this->mdate = new \Datetime();
    }

    /**
     * @ORM\OneToOne(targetEntity="Drak\BlogBundle\Entity\Image", cascade={"persist"})
     */
     private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mdate", type="datetime")
     */
    private $mdate;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=500)
     */
    private $content;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mdate
     *
     * @param \DateTime $mdate
     * @return Advert
     */
    public function setMdate($mdate)
    {
        $this->mdate = $mdate;

        return $this;
    }

    /**
     * Get mdate
     *
     * @return \DateTime
     */
    public function getMdate()
    {
        return $this->mdate;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Advert
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Advert
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Advert
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set image
     *
     * @param \Drak\BlogBundle\Entity\Image $image
     * @return Advert
     */
    public function setImage(\Drak\BlogBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Drak\BlogBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }
}
