<?php

namespace PublicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaireP")
 * @ORM\Entity(repositoryClass="PublicationBundle\Repository\CommentaireRepository")
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
   * @ORM\Column(name="description", type="string", length=255)
   */
  private $description;

  /**
   * @ORM\ManyToOne(targetEntity="Publication", inversedBy="comments")
   */
  private $publication;


  /**
   * @return string
   */
  public function getDescription()
  {
    return $this -> description;
  }

  /**
   * @param string $description
   */
  public function setDescription($description)
  {
    $this -> description = $description;
  }

  /**
   * @ORM\OneToMany(mappedBy="Publication",TargetEntity="CommentaireP")
   * @ORMJoinColumn(name="Commentaire_id",ReferencedColumnName="ty"
   *
   */
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
     * Set publication
     *
     * @param \PublicationBundle\Entity\Publication $publication
     *
     * @return Commentaire
     */
    public function setPublication(\PublicationBundle\Entity\Publication $publication = null)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return \PublicationBundle\Entity\Publication
     */
    public function getPublication()
    {
        return $this->publication;
    }
}
