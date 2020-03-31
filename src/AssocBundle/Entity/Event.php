<?php

namespace AssocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
/**
 * Event
 *
 * @ORM\Table(name="event")
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="AssocBundle\Repository\EventRepository")
 */
class Event
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="Lieu", type="string", length=255, nullable=true)
     */
    private $Lieu;

    /**
     * @var int
     *
     * @ORM\Column(name="moyenne", type="integer", nullable=true)
     */
    private $moyenne;

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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="Event")
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

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Dateevent", type="date")
     */
    private $Dateevent;

    /**
     * @return \DateTime
     */
    public function getDateevent()
    {
        return $this->Dateevent;
    }

    /**
     * @param \DateTime $Dateevent
     * @return Event
     */
    public function setDateevent($Dateevent)
    {
        $this->Dateevent = $Dateevent;
        return $this;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrInterest", type="integer")
     */
    private $nbrInterest=0;



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
     * @return string
     */
    public function getLieu()
    {
        return $this->Lieu;
    }

    /**
     * @param string $Lieu
     * @return Event
     */
    public function setLieu($Lieu)
    {
        $this->Lieu = $Lieu;
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
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
     * Set nbrInterest
     *
     * @param string $nbrInterest
     *
     * @return Event
     */
    public function setNbrInterest($nbrInterest)
    {
        $this->nbrInterest = $nbrInterest;

        return $this;
    }

    /**
     * Get nbrInterest
     *
     * @return string
     */
    public function getNbrInterest()
    {
        return $this->nbrInterest;
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


    /**
     * Set moyenne
     *
     * @param integer $moyenne
     *
     * @return Event
     */
    public function setMoyenne($moyenne)
    {
        $this->moyenne = $moyenne;

        return $this;
    }

    /**
     * Get moyenne
     *
     * @return integer
     */
    public function getMoyenne()
    {
        return $this->moyenne;
    }


    /**
     * Add rating
     *
     * @param \AssocBundle\Entity\Rating $rating
     *
     * @return Event
     */
    public function addRating(\AssocBundle\Entity\Rating $rating)
    {
        $this->ratings[] = $rating;

        return $this;
    }

    /**
     * Remove rating
     *
     * @param \AssocBundle\Entity\Rating $rating
     */
    public function removeRating(\AssocBundle\Entity\Rating $rating)
    {
        $this->ratings->removeElement($rating);
    }
}
