<?php

namespace FaimfonyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Restaurant
 *
 * @ORM\Table(name="restaurant")
 * @ORM\Entity(repositoryClass="FaimfonyBundle\Repository\RestaurantRepository")
 */
class Restaurant
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\Column(name="address", type="json_array")
     */
    private $address;

    /**
     * @var array
     *
     * @ORM\Column(name="timetable", type="json_array")
     */
    private $timetable;

    /**
     * @var string
     *
     * @ORM\Column(name="cooking_type", type="string", length=255)
     */
    private $cookingType;

    /**
     * @var string
     * @Gedmo\Slug(fields={"name"}, updatable=false, separator="-")
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="restaurants")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id");
     */
    protected $user;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Restaurant
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param array $address
     *
     * @return Restaurant
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return array
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set timetable
     *
     * @param array $timetable
     *
     * @return Restaurant
     */
    public function setTimetable($timetable)
    {
        $this->timetable = $timetable;

        return $this;
    }

    /**
     * Get timetable
     *
     * @return array
     */
    public function getTimetable()
    {
        return $this->timetable;
    }

    /**
     * Set cookingType
     *
     * @param string $cookingType
     *
     * @return Restaurant
     */
    public function setCookingType($cookingType)
    {
        $this->cookingType = $cookingType;

        return $this;
    }

    /**
     * Get cookingType
     *
     * @return string
     */
    public function getCookingType()
    {
        return $this->cookingType;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Restaurant
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Restaurant
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set user
     *
     * @param \FaimfonyBundle\Entity\User $user
     *
     * @return Restaurant
     */
    public function setUser(\FaimfonyBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \FaimfonyBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add tag
     *
     * @param \FaimfonyBundle\Entity\Tag $tag
     *
     * @return Restaurant
     */
    public function addTag(\FaimfonyBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \FaimfonyBundle\Entity\Tag $tag
     */
    public function removeTag(\FaimfonyBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }
}
