<?php

namespace CollecteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategorieCollect
 *
 * @ORM\Table(name="categorie_collect")
 * @ORM\Entity(repositoryClass="CollecteBundle\Repository\CategorieCollectRepository")
 */
class CategorieCollect
{

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="typeCategorie", type="string", length=20)
     */
    private $typeCategorie;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="CategorieCollect")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * Set typeCategorie
     *
     * @param string $typeCategorie
     *
     * @return CategorieCollect
     */
    public function setTypeCategorie($typeCategorie)
    {
        $this->typeCategorie = $typeCategorie;

        return $this;
    }

    /**
     * Get typeCategorie
     *
     * @return string
     */
    public function getTypeCategorie()
    {
        return $this->typeCategorie;
    }
}

