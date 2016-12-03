<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Cigar
 *
 * @ORM\Table(name="cigar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CigarRepository")
 */
class Cigar
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
     * @var int
     *
     * @ORM\Column(name="gauge", type="integer")
     */
    private $gauge;

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
     * @ORM\ManyToOne(targetEntity="Shape", inversedBy="cigars")
     * @JoinColumn(name="shape_id", referencedColumnName="id")
     */
    private $shape;


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
     * Set gauge
     *
     * @param integer $gauge
     *
     * @return Cigar
     */
    public function setGauge($gauge)
    {
        $this->gauge = $gauge;

        return $this;
    }

    /**
     * Get gauge
     *
     * @return int
     */
    public function getGauge()
    {
        return $this->gauge;
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
    public function setManufacturer($manufacturer)
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
     * Set shape
     *
     * @param \AppBundle\Entity\Shape $shape
     *
     * @return Cigar
     */
    public function setShape(\AppBundle\Entity\Shape $shape = null)
    {
        $this->shape = $shape;

        return $this;
    }

    /**
     * Get shape
     *
     * @return \AppBundle\Entity\Shape
     */
    public function getShape()
    {
        return $this->shape;
    }
}
