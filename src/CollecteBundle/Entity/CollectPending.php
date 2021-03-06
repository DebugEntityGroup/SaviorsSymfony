<?php

namespace CollecteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * CollectPending
 * @ORM\Table(name="collectPending")
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="CollecteBundle\Repository\CollectPendingRepository")
 */
class CollectPending
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
     * @ORM\Column(name="nomCollecte", type="string", length=20)
     */
    private $nomCollecte;

    /**
     * @var int
     *
     * @ORM\Column(name="budgetCollecte", type="integer")
     */
    private $budgetCollecte;

    /**
     * @var int
     *
     * @ORM\Column(name="nombreAtteint", type="integer")
     */
    private $nombreAtteint=0;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionCollecte", type="string", length=400)
     */
    private $descriptionCollecte;

    /**
     * @var int
     *
     * @ORM\Column(name="nombreParticipantsCollecte", type="integer")
     */
    private $nombreParticipantsCollecte=0;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;
    /**
     * @Vich\UploadableField(mapping="uploads", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieCollect::class, inversedBy="CollectPending")
     * @ORM\JoinColumn(name="categorieCollect_typeCategorie", referencedColumnName="typeCategorie",onDelete="CASCADE")
     */
    private $categorieCollect;

    /**
     * @ORM\OneToMany(targetEntity="CollectPending", mappedBy="collectPending")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $commentaires;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="CollectPending")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
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

    public function __construct()
    {
        $this->commentaires=new \Doctrine\Common\Collections\ ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * @param mixed $commentaires
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;
    }

    /**
     * @return mixed
     */
    public function getCategorieCollect()
    {
        return $this->categorieCollect;
    }

    /**
     * @param mixed $categorieCollect
     */
    public function setCategorieCollect($categorieCollect)
    {
        $this->categorieCollect = $categorieCollect;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
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
     * Set nomCollecte
     *
     * @param string $nomCollecte
     *
     * @return CollectPending
     */
    public function setNomCollecte($nomCollecte)
    {
        $this->nomCollecte = $nomCollecte;

        return $this;
    }

    /**
     * Get nomCollecte
     *
     * @return string
     */
    public function getNomCollecte()
    {
        return $this->nomCollecte;
    }

    /**
     * Set budgetCollecte
     *
     * @param integer $budgetCollecte
     *
     * @return CollectPending
     */
    public function setBudgetCollecte($budgetCollecte)
    {
        $this->budgetCollecte = $budgetCollecte;

        return $this;
    }

    /**
     * Get budgetCollecte
     *
     * @return int
     */
    public function getBudgetCollecte()
    {
        return $this->budgetCollecte;
    }

    /**
     * Set nombreAtteint
     *
     * @param integer $nombreAtteint
     *
     * @return CollectPending
     */
    public function setNombreAtteint($nombreAtteint)
    {
        $this->nombreAtteint = $nombreAtteint;

        return $this;
    }

    /**
     * Get nombreAtteint
     *
     * @return int
     */
    public function getNombreAtteint()
    {
        return $this->nombreAtteint;
    }

    /**
     * Set descriptionCollecte
     *
     * @param string $descriptionCollecte
     *
     * @return CollectPending
     */
    public function setDescriptionCollecte($descriptionCollecte)
    {
        $this->descriptionCollecte = $descriptionCollecte;

        return $this;
    }

    /**
     * Get descriptionCollecte
     *
     * @return string
     */
    public function getDescriptionCollecte()
    {
        return $this->descriptionCollecte;
    }

    /**
     * Set nombreParticipantsCollecte
     *
     * @param integer $nombreParticipantsCollecte
     *
     * @return CollectPending
     */
    public function setNombreParticipantsCollecte($nombreParticipantsCollecte)
    {
        $this->nombreParticipantsCollecte = $nombreParticipantsCollecte;

        return $this;
    }

    /**
     * Get nombreParticipantsCollecte
     *
     * @return int
     */
    public function getNombreParticipantsCollecte()
    {
        return $this->nombreParticipantsCollecte;
    }
}

