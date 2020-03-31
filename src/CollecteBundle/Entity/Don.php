<?php

namespace CollecteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Don
 *
 * @ORM\Table(name="don")
 * @ORM\Entity(repositoryClass="CollecteBundle\Repository\DonRepository")
 */
class Don
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
     * @ORM\Column(name="moneyDonated", type="integer")
     */
    private $moneyDonated;

    /**
     * @ORM\ManyToOne(targetEntity="CollectPending", inversedBy="Don")
     * @ORM\JoinColumn(name="collectPending_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $collectPending;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="CollectPending")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateHour", type="datetime", nullable=true)
     */
    private $dateHour;

    /**
     * @return \DateTime
     */
    public function getDateHour()
    {
        return $this->dateHour;
    }

    /**
     * @param \DateTime $dateHour
     */
    public function setDateHour($dateHour)
    {
        $this->dateHour = $dateHour;
        $dateHour->setTimezone(new \DateTimeZone('Europe/Paris'));
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
    public function getCollectPending()
    {
        return $this->collectPending;
    }

    /**
     * @param mixed $collectPending
     */
    public function setCollectPending($collectPending)
    {
        $this->collectPending = $collectPending;
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
     * Set moneyDonated
     *
     * @param float $moneyDonated
     *
     * @return Don
     */
    public function setMoneyDonated($moneyDonated)
    {
        $this->moneyDonated = $moneyDonated;

        return $this;
    }

    /**
     * Get moneyDonated
     *
     * @return float
     */
    public function getMoneyDonated()
    {
        return $this->moneyDonated;
    }
}

