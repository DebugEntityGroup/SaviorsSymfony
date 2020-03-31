<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *CommentaireF
 *
 * @ORM\Table(name="commentaireF")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\CommentaireRepository")

 */
class CommentaireF
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
     *  @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


    /**
     * @ORM\ManyToOne(targetEntity="Forum", inversedBy="comments")
     * @ORM\JoinColumn(name="forum_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $forum;


    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="commentaire")
     * @ORM\JoinColumn(name="users", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="rating", type="integer")
     */
private $rating;

    /**
     * @return string
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param string $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
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
    public function getForum()
    {
        return $this->forum;
    }

    /**
     * @param mixed $forum
     */
    public function setForum($forum)
    {
        $this->forum = $forum;
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
     * Set description
     *
     * @param string $description
     *
     * @return CommentaireF
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
}

