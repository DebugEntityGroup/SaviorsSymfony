<?php

namespace ReclamationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Raisons
 *
 * @ORM\Table(name="Raisons")
 * @ORM\Entity(repositoryClass="ReclamationBundle\Repository\RaisonsRepository")
 */
class Raisons
{

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="typeRaison", type="string", length=250)
     */
    private $typeRaison;

    /**
     * Set typeRaison
     *
     * @param string $typeRaison
     *
     * @return Raisons
     */
    public function setTypeRaison($typeRaison)
    {
        $this->typeRaison = $typeRaison;

        return $this;
    }

    /**
     * Get typeRaison
     *
     * @return string
     */
    public function getTypeRaison()
    {
        return $this->typeRaison;
    }

}

