<?php

namespace CollecteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentaireF
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="CollecteBundle\Repository\CommentaireRepository")
 */
class Commentaire
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
     * @ORM\Column(name="contenu", type="string", length=500)
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity="CollectPending", inversedBy="commentaires")
     * @ORM\JoinColumn(name="collectPending_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $collectPending;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="commentaires")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Commentaire
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }
}

