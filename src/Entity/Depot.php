<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\DepotController;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  collectionOperations={
 *         "GET"={
 *               
*               },
*               "POST"={
 *                  
*                    "controller"=DepotController::class,

*                }
* 
*     },
*  itemOperations={
*          "GET"={
*                "access_control"="is_granted('VIEW',  previous_object)",
*               },
*          "put"={
 *              "access_control"="is_granted('EDIT', previous_object)",
 *          },
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\DepotRepository")
 */
class Depot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read","write"})
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read","write"})
     */
    private $dateDepot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="depots", cascade={"persist"})
     */
    private $compte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="depots", cascade={"persist"})
     */
    private $user;


    public function __construct()
    {
        $this->dateDepot = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getMontant(): ?int
    {
        return $this->montant;
    }
    
    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }


    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
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

    
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
