<?php

namespace ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Produitcomment
 *
 *
 * @ORM\Entity(repositoryClass="ProduitBundle\Repository\ProduitcommentRepository")
 * @ORM\Table(name="produitcomment")
 * @ORM\HasLifecycleCallbacks()
 */
class Produitcomment
{
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", unique=false)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=ProduitPending::class, inversedBy="comments")
     * @ORM\JoinColumn(name="produitPending_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $produitPending;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    protected $id;

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
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
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
    public function getProduitPending()
    {
        return $this->produitPending;
    }
    /**
     * @param mixed $produitPending
     */
    public function setProduitPending($produitPending)
    {
        $this->produitPending = $produitPending;
    }

}

