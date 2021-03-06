<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wrapper
 *
 * @ORM\Table(name="wrapper")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WrapperRepository")
 */
class Wrapper
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
     * @var string
     *
     * @ORM\Column(name="color", type="text")
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity="Cigar", mappedBy="wrapper")
     */
    private $cigars;

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
     * @return Wrapper
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
     * @return Wrapper
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
     * @return Wrapper
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
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }


}
