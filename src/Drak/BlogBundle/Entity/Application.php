<?php

namespace Drak\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 *
 * @ORM\Table("drk_application")
 * @ORM\Entity(repositoryClass="Drak\BlogBundle\Entity\ApplicationRepository")
 */
class Application
{

    public function __construct()
    {
        $this->apdate = new \Datetime();
    }

    /**
     * @ORM\ManyToOne(targetEntity="Drak\BlogBundle\Entity\Advert", inversedBy="applications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $advert;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="apdate", type="datetime")
     */
    private $apdate;


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
     * Set author
     *
     * @param string $author
     * @return Application
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
     * @return Application
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
     * Set apdate
     *
     * @param \DateTime $apdate
     * @return Application
     */
    public function setApdate($apdate)
    {
        $this->apdate = $apdate;

        return $this;
    }

    /**
     * Get apdate
     *
     * @return \DateTime
     */
    public function getApdate()
    {
        return $this->apdate;
    }

    /**
     * Set advert
     *
     * @param \Drak\BlogBundle\Entity\Advert $advert
     * @return Application
     */
    public function setAdvert(\Drak\BlogBundle\Entity\Advert $advert)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get advert
     *
     * @return \Drak\BlogBundle\Entity\Advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * @ORM\PrePersist
     */
     public function increase()
     {
         $this->getAdvert()->increaseApplication();
     }

     /**
      * @ORM\PrePersist
      */
      public function decrease()
      {
          $this->getAdvert()->decreaseApplication();
      }

}
