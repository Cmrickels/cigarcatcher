<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Cigar;
use Symfony\Component\Validator\Constraints\DateTime;
use UserBundle\Entity\User;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Humidor
 *
 * @ORM\Table(name="humidor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HumidorRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Humidor
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="humidors")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Cigar")
     * @ORM\JoinColumn(name="slot_1", referencedColumnName="id")
     */
    private $slot1;

    /**
     * @ORM\ManyToOne(targetEntity="Cigar")
     * @ORM\JoinColumn(name="slot_2", referencedColumnName="id")
     */
    private $slot2;

        /**
         * @ORM\ManyToOne(targetEntity="Cigar")
         * @ORM\JoinColumn(name="slot_3", referencedColumnName="id")
         */
    private $slot3;

        /**
         * @ORM\ManyToOne(targetEntity="Cigar")
         * @ORM\JoinColumn(name="slot_4", referencedColumnName="id")
         */
    private $slot4;

        /**
         * @ORM\ManyToOne(targetEntity="Cigar")
         * @ORM\JoinColumn(name="slot_5", referencedColumnName="id")
         */
    private $slot5;

        /**
         * @ORM\ManyToOne(targetEntity="Cigar")
         * @ORM\JoinColumn(name="slot_6", referencedColumnName="id")
         */
    private $slot6;

        /**
         * @ORM\ManyToOne(targetEntity="Cigar")
         * @ORM\JoinColumn(name="slot_7", referencedColumnName="id")
         */
    private $slot7;

        /**
         * @ORM\ManyToOne(targetEntity="Cigar")
         * @ORM\JoinColumn(name="slot_8", referencedColumnName="id")
         */
    private $slot8;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot1TimeAdded", type="datetime", nullable=true )
     */
    private $slot1TimeAdded;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot2TimeAdded", type="datetime", nullable=true )
     */
    private $slot2TimeAdded;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot3TimeAdded", type="datetime", nullable=true )
     */
    private $slot3TimeAdded;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot4TimeAdded", type="datetime", nullable=true )
     */
    private $slot4TimeAdded;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot5TimeAdded", type="datetime", nullable=true )
     */
    private $slot5TimeAdded;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot6TimeAdded", type="datetime", nullable=true )
     */
    private $slot6TimeAdded;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot7TimeAdded", type="datetime" ,nullable=true )
     */
    private $slot7TimeAdded;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot8TimeAdded", type="datetime", nullable=true )
     */
    private $slot8TimeAdded;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot1Age", type="integer", nullable=true)
     */
    private $slot1Age;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot2Age", type="datetime", nullable=true)
     */
    private $slot2Age;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot3Age", type="datetime", nullable=true)
     */
    private $slot3Age;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot4Age", type="datetime", nullable=true)
     */
    private $slot4Age;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot5Age", type="datetime", nullable=true)
     */
    private $slot5Age;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot6Age", type="datetime", nullable=true)
     */
    private $slot6Age;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot7Age", type="datetime", nullable=true)
     */
    private $slot7Age;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="slot8Age", type="datetime", nullable=true)
     */
    private $slot8Age;

    /**
     * @ORM\PostLoad
     */
    public function setAllAges()
    {

        if($this->getSlot1() != null)
        {
            if($this->getSlot1TimeAdded() != null){
                $created = strtotime($this->getSlot1TimeAdded()->format('Y-m-d H:i:s'));
                $now = strtotime(date('Y-m-d H:i:s'));
                $difference = $now - $created;
                $differenceDisplay = $difference / 86400;
                $this->setSlot1Age((int)$differenceDisplay);

            }
        }
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
     * @return Humidor
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
    public function getSlot1()
    {
        return $this->slot1;
    }

    /**
     * @param mixed $slot1
     */
    public function setSlot1($slot1)
    {
        $this->slot1 = $slot1;
    }

    /**
     * @return mixed
     */
    public function getSlot2()
    {
        return $this->slot2;
    }

    /**
     * @param mixed $slot2
     */
    public function setSlot2($slot2)
    {
        $this->slot2 = $slot2;
    }

    /**
     * @return mixed
     */
    public function getSlot3()
    {
        return $this->slot3;
    }

    /**
     * @param mixed $slot3
     */
    public function setSlot3($slot3)
    {
        $this->slot3 = $slot3;
    }

    /**
     * @return mixed
     */
    public function getSlot4()
    {
        return $this->slot4;
    }

    /**
     * @param mixed $slot4
     */
    public function setSlot4($slot4)
    {
        $this->slot4 = $slot4;
    }

    /**
     * @return mixed
     */
    public function getSlot5()
    {
        return $this->slot5;
    }

    /**
     * @param mixed $slot5
     */
    public function setSlot5($slot5)
    {
        $this->slot5 = $slot5;
    }

    /**
     * @return mixed
     */
    public function getSlot6()
    {
        return $this->slot6;
    }

    /**
     * @param mixed $slot6
     */
    public function setSlot6($slot6)
    {
        $this->slot6 = $slot6;
    }

    /**
     * @return mixed
     */
    public function getSlot7()
    {
        return $this->slot7;
    }

    /**
     * @param mixed $slot7
     */
    public function setSlot7($slot7)
    {
        $this->slot7 = $slot7;
    }

    /**
     * @return mixed
     */
    public function getSlot8()
    {
        return $this->slot8;
    }

    /**
     * @param mixed $slot8
     */
    public function setSlot8($slot8)
    {
        $this->slot8 = $slot8;
    }

    /**
     * @return DateTime
     */
    public function getSlot1TimeAdded()
    {
        return $this->slot1TimeAdded;
    }

    /**
     * @param DateTime $slot1TimeAdded
     */
    public function setSlot1TimeAdded($slot1TimeAdded)
    {
        $this->slot1TimeAdded = $slot1TimeAdded;
    }

    /**
     * @return DateTime
     */
    public function getSlot2TimeAdded()
    {
        return $this->slot2TimeAdded;
    }

    /**
     * @param DateTime $slot2TimeAdded
     */
    public function setSlot2TimeAdded($slot2TimeAdded)
    {
        $this->slot2TimeAdded = $slot2TimeAdded;
    }

    /**
     * @return DateTime
     */
    public function getSlot3TimeAdded()
    {
        return $this->slot3TimeAdded;
    }

    /**
     * @param DateTime $slot3TimeAdded
     */
    public function setSlot3TimeAdded($slot3TimeAdded)
    {
        $this->slot3TimeAdded = $slot3TimeAdded;
    }

    /**
     * @return DateTime
     */
    public function getSlot4TimeAdded()
    {
        return $this->slot4TimeAdded;
    }

    /**
     * @param DateTime $slot4TimeAdded
     */
    public function setSlot4TimeAdded($slot4TimeAdded)
    {
        $this->slot4TimeAdded = $slot4TimeAdded;
    }

    /**
     * @return DateTime
     */
    public function getSlot5TimeAdded()
    {
        return $this->slot5TimeAdded;
    }

    /**
     * @param DateTime $slot5TimeAdded
     */
    public function setSlot5TimeAdded($slot5TimeAdded)
    {
        $this->slot5TimeAdded = $slot5TimeAdded;
    }

    /**
     * @return DateTime
     */
    public function getSlot6TimeAdded()
    {
        return $this->slot6TimeAdded;
    }

    /**
     * @param DateTime $slot6TimeAdded
     */
    public function setSlot6TimeAdded($slot6TimeAdded)
    {
        $this->slot6TimeAdded = $slot6TimeAdded;
    }

    /**
     * @return DateTime
     */
    public function getSlot7TimeAdded()
    {
        return $this->slot7TimeAdded;
    }

    /**
     * @param DateTime $slot7TimeAdded
     */
    public function setSlot7TimeAdded($slot7TimeAdded)
    {
        $this->slot7TimeAdded = $slot7TimeAdded;
    }

    /**
     * @return DateTime
     */
    public function getSlot8TimeAdded()
    {
        return $this->slot8TimeAdded;
    }

    /**
     * @param DateTime $slot8TimeAdded
     */
    public function setSlot8TimeAdded($slot8TimeAdded)
    {
        $this->slot8TimeAdded = $slot8TimeAdded;
    }

    /**
     * @return DateTime
     */
    public function getSlot1Age()
    {
        return $this->slot1Age;
    }

    /**
     * @param DateTime $slot1Age
     */
    public function setSlot1Age($slot1Age)
    {
        $this->slot1Age = $slot1Age;
    }

    /**
     * @return mixed
     */
    public function getSlot2Age()
    {
        return $this->slot2Age;
    }

    /**
     * @param mixed $slot2Age
     */
    public function setSlot2Age($slot2Age)
    {
        $this->slot2Age = $slot2Age;
    }

    /**
     * @return mixed
     */
    public function getSlot3Age()
    {
        return $this->slot3Age;
    }

    /**
     * @param mixed $slot3Age
     */
    public function setSlot3Age($slot3Age)
    {
        $this->slot3Age = $slot3Age;
    }

    /**
     * @return mixed
     */
    public function getSlot4Age()
    {
        return $this->slot4Age;
    }

    /**
     * @param mixed $slot4Age
     */
    public function setSlot4Age($slot4Age)
    {
        $this->slot4Age = $slot4Age;
    }

    /**
     * @return mixed
     */
    public function getSlot5Age()
    {
        return $this->slot5Age;
    }

    /**
     * @param mixed $slot5Age
     */
    public function setSlot5Age($slot5Age)
    {
        $this->slot5Age = $slot5Age;
    }

    /**
     * @return mixed
     */
    public function getSlot6Age()
    {
        return $this->slot6Age;
    }

    /**
     * @param mixed $slot6Age
     */
    public function setSlot6Age($slot6Age)
    {
        $this->slot6Age = $slot6Age;
    }

    /**
     * @return mixed
     */
    public function getSlot7Age()
    {
        return $this->slot7Age;
    }

    /**
     * @param mixed $slot7Age
     */
    public function setSlot7Age($slot7Age)
    {
        $this->slot7Age = $slot7Age;
    }

    /**
     * @return mixed
     */
    public function getSlot8Age()
    {
        return $this->slot8Age;
    }

    /**
     * @param mixed $slot8Age
     */
    public function setSlot8Age($slot8Age)
    {
        $this->slot8Age = $slot8Age;
    }
}

