<?php
namespace UserBundle\Entity;

use AppBundle\Entity\Humidor;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Humidor", mappedBy="user", cascade={"persist"})
     */
    protected $humidors;

    /**
     * @var@ORM\OneToMany(targetEntity="AppBundle\Entity\Experience", mappedBy="user", cascade={"persist"})
     */
    protected $experiences;

    public function __construct()
    {
        parent::__construct();
        $this->humidors = new ArrayCollection();
        $this->experiences = new ArrayCollection();

        $humidor = new Humidor();
        $this->addHumidors($humidor);
        $humidor->setUser($this);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getHumidors()
    {
        return $this->humidors;
    }

    /**
     * @param \AppBundle\Entity\Humidor $humidors
     * @return User
     */
    public function addHumidors($humidors)
    {
        $this->humidors[] = $humidors;
    }

    /**
     * @return mixed
     */
    public function getExperiences()
    {
        return $this->experiences;
    }

    /**
     * @param mixed $experiences
     */
    public function addExperiences($experience)
    {
        $this->experiences[] = $experience;
    }



}
