<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
  * @ApiResource(
 *  collectionOperations={
 *        "get"={
*                  
 *              },
 *         "post"={
 *             "access_control"="is_granted('ADD', object)",
 * }
 *     },
 *   itemOperations={
 *        "get"={"access_control"="is_granted('VIEW', object)",
 * 
 *      },
 *      "put"={
 *          "access_control"="is_granted('EDIT', object)",
 *     
 *      },
 * },)
 * @ORM\Entity(repositoryClass="App\Repository\AffectationRepository")
 */
class Affectation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_Affectation;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_Expiration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="affectations")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="affectations")
     */
    private $compte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAffectation(): ?\DateTimeInterface
    {
        return $this->date_Affectation;
    }

    public function setDateAffectation(\DateTimeInterface $date_Affectation): self
    {
        $this->date_Affectation = $date_Affectation;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->date_Expiration;
    }

    public function setDateExpiration(?\DateTimeInterface $date_Expiration): self
    {
        $this->date_Expiration = $date_Expiration;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }
}
