<?php

namespace PublicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aime
 *
 * @ORM\Table(name="aime")
 * @ORM\Entity(repositoryClass="PublicationBundle\Repository\AimeRepository")
 */
class Aime
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
   * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
   * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
   */
  private $user;

  /**
   * @ORM\ManyToMany(targetEntity="Publication", mappedBy="likes")
   */
  private $publications;

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
   * Constructor
   */
  public function __construct()
  {
    $this -> publications = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * Set user
   *
   * @param \UserBundle\Entity\User $user
   *
   * @return Aime
   */
  public function setUser(\UserBundle\Entity\User $user = null)
  {
    $this -> user = $user;

    return $this;
  }

  /**
   * Get user
   *
   * @return \UserBundle\Entity\User
   */
  public function getUser()
  {
    return $this -> user;
  }

  /**
   * Add publication
   *
   * @param \PublicationBundle\Entity\Publication $publication
   *
   * @return Aime
   */
  public function addPublication(\PublicationBundle\Entity\Publication $publication)
  {
    $publication -> addLike($this);
    $this -> publications[] = $publication;

    return $this;
  }

  /**
   * Remove publication
   *
   * @param \PublicationBundle\Entity\Publication $publication
   */
  public function removePublication(\PublicationBundle\Entity\Publication $publication)
  {
    $this -> publications -> removeElement($publication);
  }

  /**
   * Get publications
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getPublications()
  {
    return $this -> publications;
  }
}
