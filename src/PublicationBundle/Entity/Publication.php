<?php

namespace PublicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table(name="publication")
 * @ORM\Entity(repositoryClass="PublicationBundle\Repository\PublicationRepository")
 */
class Publication
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
   * @ORM\Column(name="titre", type="string", length=255)
   */
  private $titre;

  /**
   * @var string
   *
   * @ORM\Column(name="description", type="string", length=255)
   */
  private $description;

  /**
   * @ORM\OneToMany(targetEntity="Commentaire", mappedBy="publication")
   */
  private $comments;

  /**
   * @ORM\ManyToMany(targetEntity="Aime", inversedBy="publications")
   */
  private $likes;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $brochureFilename;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $video;


  /**
   * Get id
   *
   * @return int
   */
  public function getId()
  {
    return $this -> id;
  }

  /**
   * Set titre
   *
   * @param string $titre
   *
   * @return Publication
   */
  public function setTitre($titre)
  {
    $this -> titre = $titre;

    return $this;
  }

  /**
   * Get titre
   *
   * @return string
   */
  public function getTitre()
  {
    return $this -> titre;
  }

  /**
   * Set description
   *
   * @param string $description
   *
   * @return Publication
   */
  public function setDescription($description)
  {
    $this -> description = $description;

    return $this;
  }

  /**
   * Get description
   *
   * @return string
   */
  public function getDescription()
  {
    return $this -> description;
  }

  /**
   * Constructor
   */
  public function __construct()
  {
    $this -> comments = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * Add comment
   *
   * @param \PublicationBundle\Entity\CommentaireP $comment
   *
   * @return Publication
   */
  public function addComment(\PublicationBundle\Entity\CommentaireP $comment)
  {
    $this -> comments[] = $comment;

    return $this;
  }

  /**
   * Remove comment
   *
   * @param \PublicationBundle\Entity\CommentaireP $comment
   */
  public function removeComment(\PublicationBundle\Entity\CommentaireP $comment)
  {
    $this -> comments -> removeElement($comment);
  }

  /**
   * Get comments
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getComments()
  {
    return $this -> comments;
  }

  /**
   * Add like
   *
   * @param \PublicationBundle\Entity\Aime $like
   *
   * @return Publication
   */
  public function addLike(\PublicationBundle\Entity\Aime $like)
  {
    $this -> likes[] = $like;

    return $this;
  }

  /**
   * Remove like
   *
   * @param \PublicationBundle\Entity\Aime $like
   */
  public function removeLike(\PublicationBundle\Entity\Aime $like)
  {
    $this -> likes -> removeElement($like);
  }

  /**
   * Get likes
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getLikes()
  {
    return $this -> likes;
  }

  public function hasCurrentUserLike(int $userId): bool
  {
    foreach ($this -> likes as $like) {
      if ($like -> getUser() -> getId() === $userId) return true;
    }
    return false;
  }

  public function getBrochureFilename()
  {
    return $this->brochureFilename;
  }

  public function setBrochureFilename($brochureFilename)
  {
    $this->brochureFilename = $brochureFilename;

    return $this;
  }

  public function getVideo()
  {
    return str_replace('watch?v=', 'embed/', $this->video);
  }

  public function setVideo($video)
  {
    $this->video = $video;

    return $this;
  }
}
