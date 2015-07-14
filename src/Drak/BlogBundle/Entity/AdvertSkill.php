<?php

namespace Drak\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdvertSkill
 *
 * @ORM\Table("drk_advertskill")
 * @ORM\Entity(repositoryClass="Drak\BlogBundle\Entity\AdvertSkillRepository")
 */
class AdvertSkill
{
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
     * @ORM\Column(name="level", type="string", length=255)
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="Drak\BlogBundle\Entity\Advert", inversedBy="advertskill")
     * @ORM\JoinColumn(nullable=false)
     */
     private $advert;

     /**
      * @ORM\ManyToOne(targetEntity="Drak\BlogBundle\Entity\Skill")
      * @ORM\JoinColumn(nullable=false)
      */
      private $skill;

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
     * Set level
     *
     * @param string $level
     * @return AdvertSkill
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set advert
     *
     * @param \Drak\BlogBundle\Entity\Advert $advert
     * @return AdvertSkill
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
     * Set skill
     *
     * @param \Drak\BlogBundle\Entity\Skill $skill
     * @return AdvertSkill
     */
    public function setSkill(\Drak\BlogBundle\Entity\Skill $skill)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return \Drak\BlogBundle\Entity\Skill
     */
    public function getSkill()
    {
        return $this->skill;
    }
}
