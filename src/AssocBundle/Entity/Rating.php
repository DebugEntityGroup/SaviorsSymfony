<?php

namespace AssocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="AssocBundle\Repository\RatingRepository")
 */
class Rating
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
     * @ORM\Column(name="note", type="integer")
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="EventPending", inversedBy="ratings")
     * @ORM\JoinColumn(name="eventPending_id", referencedColumnName="id")
     */
    private $eventPending;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="ratings")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;


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
     * Set note
     *
     * @param integer $note
     *
     * @return Rating
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }



    /**
     * Set eventPending
     *
     * @param \AssocBundle\Entity\EventPending $eventPending
     *
     * @return Rating
     */
    public function setEventPending(\AssocBundle\Entity\EventPending $eventPending = null)
    {
        $this->eventPending = $eventPending;

        return $this;
    }

    /**
     * Get eventPending
     *
     * @return \AssocBundle\Entity\EventPending
     */
    public function getEventPending()
    {
        return $this->eventPending;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Rating
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
