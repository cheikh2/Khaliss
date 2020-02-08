<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\CompteController;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *    denormalizationContext={"groups"={"write"}},
 * collectionOperations={
 *          
 *         "GET"={
 *               

*               },
*               "POST"={
 *                 
*                  "controller"=CompteController::class,  

*                }
* 
*     },
*  itemOperations={
*          "GET"={
*                   "access_control"="is_granted('VIEW',  previous_object)",
*               },
*          "put"={
 *              "access_control"="is_granted('EDIT', previous_object)",
 *          },
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CompteRepository")
 */
class Compte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read","write"})
     */
    private $numCompte;

    /**
     * @ORM\Column(type="integer")
     */
    private $solde;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read","write"})
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="compte", cascade={"persist"})
     * @Groups({"read","write"})
     */
    private $depots;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="comptes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read","write"})
     */
    private $partenaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comptes", cascade={"persist"})
     */
    private $user;

    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    
    public function getNumCompte(): ?string
    {
        return $this->numCompte;
    }

    public function setNumCompte(string $numCompte): self
    {
        $this->numCompte = $numCompte;

        return $this;
    }

  
    public function getSolde(): ?int
    {
        return $this->solde;
    }
    
    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

   
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * 
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setCompte($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getCompte() === $this) {
                $depot->setCompte(null);
            }
        }

        return $this;
    }

   
    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }
   
    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

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
