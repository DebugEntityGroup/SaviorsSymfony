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

