<?php

namespace AssocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment_event")
 * @ORM\Entity(repositoryClass="AssocBundle\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="EventPending", inversedBy="comments")
     * @ORM\JoinColumn(name="eventPending_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $eventPending;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="comments")
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
     * Set text
     *
     * @param string $text
     *
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set eventPending
     *
     * @param \AssocBundle\Entity\EventPending $eventPending
     *
     * @return Comment
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
     * @return Comment
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AssocBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
