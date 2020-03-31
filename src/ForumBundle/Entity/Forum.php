<?php

namespace ForumBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * forum
 *
 * @ORM\Table(name="forum")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\ForumRepository")
 */
class Forum
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
     * @ORM\Column(name="sujet", type="string", length=255)
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="CategorieForum", inversedBy="Forum")
     * @ORM\JoinColumn(name="categorieForum_id", referencedColumnName="id")
     */
    private $categorieForum;

    /**
     * @return mixed
     */
    public function getCategorieForum()
    {
        return $this->categorieForum;
    }

    /**
     * @param mixed $categorieForum
     */
    public function setCategorieForum($categorieForum)
    {
        $this->categorieForum = $categorieForum;
    }

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="Forum")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;



    /**
     * @ORM\OneToMany(targetEntity=Forum::class, mappedBy="forum")

     */
    private $comments;



    public function __construct()
    {
        $this->comments=new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
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




    public function getId()
    {
        return $this->id;
    }


    /**
     * Set sujet
     *
     * @param string $sujet
     *
     * @return forum
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Get sujet
     *
     * @return string
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return forum
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

