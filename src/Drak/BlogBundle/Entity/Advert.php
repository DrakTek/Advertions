<?php

namespace Drak\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Advert
 *
 * @ORM\Table("drk_advert")
 * @ORM\Entity(repositoryClass="Drak\BlogBundle\Entity\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Advert
{
    public function __construct()
    {
        $this->mdate = new \Datetime();
        $this->categories = new ArrayCollection();
    }

    /**
     * @ORM\OneToMany(targetEntity="Drak\BlogBundle\Entity\Application", mappedBy="advert")
     */
     private $applications;

    /**
     * @ORM\ManyTOMany(targetEntity="Drak\BlogBundle\Entity\Category", cascade={"persist"})
     */
     private $categories;

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
    * @ORM\Column(name="updated_at", type="datetime", nullable=true)
    */
    private $updatedAt;

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

    /**
     * Add categories
     *
     * @param \Drak\BlogBundle\Entity\Category $categories
     * @return Advert
     */
    public function addCategory(\Drak\BlogBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Drak\BlogBundle\Entity\Category $categories
     */
    public function removeCategory(\Drak\BlogBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add applications
     *
     * @param \Drak\BlogBundle\Entity\Application $applications
     * @return Advert
     */
    public function addApplication(\Drak\BlogBundle\Entity\Application $applications)
    {
        $this->applications[] = $applications;
        // on lie l'annonce a la candidature
        $application->setAdvert($this);

        return $this;
    }

    /**
     * Remove applications
     *
     * @param \Drak\BlogBundle\Entity\Application $applications
     */
    public function removeApplication(\Drak\BlogBundle\Entity\Application $applications)
    {
        $this->applications->removeElement($applications);
        // et si notre relation etait facultative (nullable=true,
        // ce qui n'est pas notre cas ici sinon attention)
        // $application->setAdvert(null)
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Advert
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


    // cycle de vie de advert
    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setUpdatedAt(new \Datetime());
    }

    /**
   * @ORM\Column(name="nb_applications", type="integer")
   */
   private $nbApplications = 0;

   public function increaseApplication()
   {
       $this->nbApplications++;
   }

   public function decreaseApplication()
   {
       $this->nbApplications--;
   }

    /**
     * Set nbApplications
     *
     * @param integer $nbApplications
     * @return Advert
     */
    public function setNbApplications($nbApplications)
    {
        $this->nbApplications = $nbApplications;

        return $this;
    }

    /**
     * Get nbApplications
     *
     * @return integer 
     */
    public function getNbApplications()
    {
        return $this->nbApplications;
    }
}