<?php

namespace ReclamationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use mysql_xdevapi\TableUpdate;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * ReclamationPending
 *
 * @ORM\Table(name="reclamationPending")
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="ReclamationBundle\Repository\ReclamationPendingRepository")
 */
class ReclamationPending
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
     * @ORM\Column(name="objet", type="string", length=255)
     */
    private $objet;

    /**
     * @var TableUpdate
     *
     * @ORM\Column(name="datereclamation", type="date", length=10)
     */
    private $dateReclamation;

    /**
     * @return TableUpdate
     */
    public function getDateReclamation()
    {
        return $this->dateReclamation;
    }

    /**
     * @param TableUpdate $dateReclamation
     */
    public function setDateReclamation($dateReclamation)
    {
        $this->dateReclamation = $dateReclamation;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;
    /**
     * @Vich\UploadableField(mapping="events", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * Set objet
     *
     * @param string $objet
     *
     * @return Reclamation
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;

        return $this;
    }

    /**
     * Get objet
     *
     * @return string
     */
    public function getObjet()
    {
        return $this->objet;
    }
    /**
     * @ORM\ManyToOne(targetEntity="Raisons" )
     *
     * @ORM\JoinColumn(name="raisons_typeRaison",referencedColumnName="typeRaison", onDelete="CASCADE")
     */
    private $raisons;
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="ReclamationPending")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id", onDelete="CASCADE")
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
     * @return mixed
     */
    public function getRaisons()
    {
        return $this->raisons;
    }

    /**
     * @param mixed $raisons
     */
    public function setRaisons($raisons)
    {
        $this->raisons = $raisons;
    }



    /**
     * Set description
     *
     * @param string $description
     *
     * @return Reclamation
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



}

