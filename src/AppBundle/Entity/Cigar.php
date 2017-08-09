<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Manufacturer;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use AppBundle\Entity\Wrapper;
use AppBundle\Entity\Shape;


/**
 * Cigar
 *
 * @ORM\Table(name="cigar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CigarRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Cigar
{
    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist(){
        $this->setName($this->getManufacturer()->getName() . " " . $this->getVariant());
    }

    public function __construct(){
        $this->experiences = new \Doctrine\Common\Collections\ArrayCollection();
        $this->shapes = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @ORM\Column(name="body", type="string", length=255)
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="wrapper_country", type="string", length=255)
     */
    private $wrapperCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="variant", type="string", length=255)
     */
    private $variant;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="filler_country", type="string", length=255)
     */
    private $fillerCountry;

    /**
     * @ORM\ManyToOne(targetEntity="Manufacturer", inversedBy="cigars")
     * @JoinColumn(name="manufacturer_id", referencedColumnName="id")
     */
    private $manufacturer;

    /**
     * @ORM\ManyToOne(targetEntity="Wrapper", inversedBy="cigars")
     * @JoinColumn(name="wrapper_id", referencedColumnName="id")
     */
    private $wrapper;

    /**
     * @ORM\ManyToMany(targetEntity="Shape", inversedBy="cigars")
     * @ORM\JoinTable(name="cigar_shapes")
     */
    private $shapes;

    /**
     * @ORM\Column(type="string")
     *
     */
    private $image;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Experience", mappedBy="cigar")
     */
    private $experiences;

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
     * Set body
     *
     * @param string $body
     *
     * @return Cigar
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set wrapperCountry
     *
     * @param string $wrapperCountry
     *
     * @return Cigar
     */
    public function setWrapperCountry($wrapperCountry)
    {
        $this->wrapperCountry = $wrapperCountry;

        return $this;
    }

    /**
     * Get wrapperCountry
     *
     * @return string
     */
    public function getWrapperCountry()
    {
        return $this->wrapperCountry;
    }

    /**
     * Set manufacturer
     *
     * @param string $manufacturer
     *
     * @return Cigar
     */
    public function setManufacturer(Manufacturer $manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return string
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set variant
     *
     * @param string $variant
     *
     * @return Cigar
     */
    public function setVariant($variant)
    {
        $this->variant = $variant;

        return $this;
    }

    /**
     * Get variant
     *
     * @return string
     */
    public function getVariant()
    {
        return $this->variant;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Cigar
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set fillerCountry
     *
     * @param string $fillerCountry
     *
     * @return Cigar
     */
    public function setFillerCountry($fillerCountry)
    {
        $this->fillerCountry = $fillerCountry;

        return $this;
    }

    /**
     * Get fillerCountry
     *
     * @return string
     */
    public function getFillerCountry()
    {
        return $this->fillerCountry;
    }

    /**
     * Set wrapper
     *
     * @param \AppBundle\Entity\Wrapper $wrapper
     *
     * @return Cigar
     */
    public function setWrapper(\AppBundle\Entity\Wrapper $wrapper = null)
    {
        $this->wrapper = $wrapper;

        return $this;
    }

    /**
     * Get wrapper
     *
     * @return \AppBundle\Entity\Wrapper
     */
    public function getWrapper()
    {
        return $this->wrapper;
    }

    /**
     * @param \AppBundle\Entity\Shape|null $shapes
     * @return $this
     */
    public function addShapes(\AppBundle\Entity\Shape $shapes = null)
    {
        $this->shapes[] = $shapes;

        return $this;
    }

    /**
     * Get shape
     *
     * @return \AppBundle\Entity\Shape
     */
    public function getShapes()
    {
        return $this->shapes;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getname()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setname($name)
    {
        $this->name = $name;
    }

    /**
     * @param Experience $experience
     * @return $this
     */
    public function addExperience(\AppBundle\Entity\Experience $experience)
    {
        $this->experiences[] = $experience;

        return $this;
    }

    /**
     * @param Experience $experience
     */
    public function removeExperience(\AppBundle\Entity\Experience $experience)
    {
        $this->experiences->removeElement($experience);
    }



}
