<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Experience
 *
 * @ORM\Table(name="experience")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExperienceRepository")
 */
class Experience
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
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Cigar", inversedBy="experiences")
     * @ORM\JoinColumn(name="cigar_id", referencedColumnName="id")
     */
    private $cigar;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="experiences")
     * @ORM\JoinColumn(name="experience", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(name="submissionDate", type="datetime", nullable=true )
     */
    private $submissionDate;


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
     * Set description
     *
     * @param string $description
     *
     * @return Experience
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
     * @return mixed
     */
    public function getCigar()
    {
        return $this->cigar;
    }

    /**
     * @param mixed $cigar
     */
    public function setCigar($cigar)
    {
        $this->cigar = $cigar;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getSubmissionDate()
    {
        return $this->submissionDate;
    }

    /**
     * @param mixed $submissionDate
     */
    public function setSubmissionDate($submissionDate)
    {
        $this->submissionDate = $submissionDate;
    }

}

