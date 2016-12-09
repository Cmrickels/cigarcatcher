<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shape
 *
 * @ORM\Table(name="shape")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShapeRepository")
 */
class Shape
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
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Cigar", mappedBy="shape")
     */
    private $cigars;

    /**
     * @ORM\Column(type="string")
     *
     */
    private $image;

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
     * @return Shape
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
     * Set description
     *
     * @param string $description
     *
     * @return Shape
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
     * Constructor
     */
    public function __construct()
    {
        $this->cigars = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cigar
     *
     * @param \AppBundle\Entity\Cigar $cigar
     *
     * @return Shape
     */
    public function addCigar(\AppBundle\Entity\Cigar $cigar)
    {
        $this->cigars[] = $cigar;

        return $this;
    }

    /**
     * Remove cigar
     *
     * @param \AppBundle\Entity\Cigar $cigar
     */
    public function removeCigar(\AppBundle\Entity\Cigar $cigar)
    {
        $this->cigars->removeElement($cigar);
    }

    /**
     * Get cigars
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCigars()
    {
        return $this->cigars;
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
}
