<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\CompteController;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 **
 * @ORM\Entity(repositoryClass="App\Repository\CompteRepository")
 * @ApiResource(
 *  normalizationContext={"groups"={"read"}},
 *  denormalizationContext={"groups"={"write"}},
 * collectionOperations={
 *          
 *         "GET"={
*               },
*               "POST"={
*                    "controller"=CompteController::class,
*                    
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
 *  
 * )
 *
 */
class Compte
{
    /**
     * @Groups({"read"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     */
    private $numCompte;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="integer")
     */
    private $solde;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read"})
     */
    private $createdAt;

    /**
     * @Groups({"read", "write"})
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="compte", cascade={"persist"})
     */
    private $depots;

    /**
     * @Groups({"read", "write"})
     * @ApiFilter(SearchFilter::class, properties={"partenaire.ninea": "exact"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="comptes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $partenaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comptes", cascade={"persist"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Affectation", mappedBy="compte")
     */
    private $affectations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="compte")
     */
    private $transactions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="compteRetrai")
     */
    private $compteRetrait;

    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->affectations = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->compteRetrait = new ArrayCollection();
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

    /**
     * @return Collection|Affectation[]
     */
    public function getAffectations(): Collection
    {
        return $this->affectations;
    }

    public function addAffectation(Affectation $affectation): self
    {
        if (!$this->affectations->contains($affectation)) {
            $this->affectations[] = $affectation;
            $affectation->setCompte($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): self
    {
        if ($this->affectations->contains($affectation)) {
            $this->affectations->removeElement($affectation);
            // set the owning side to null (unless already changed)
            if ($affectation->getCompte() === $this) {
                $affectation->setCompte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setCompte($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getCompte() === $this) {
                $transaction->setCompte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getCompteRetrait(): Collection
    {
        return $this->compteRetrait;
    }

    public function addCompteRetrait(Transaction $compteRetrait): self
    {
        if (!$this->compteRetrait->contains($compteRetrait)) {
            $this->compteRetrait[] = $compteRetrait;
            $compteRetrait->setCompteRetrai($this);
        }

        return $this;
    }

    public function removeCompteRetrait(Transaction $compteRetrait): self
    {
        if ($this->compteRetrait->contains($compteRetrait)) {
            $this->compteRetrait->removeElement($compteRetrait);
            // set the owning side to null (unless already changed)
            if ($compteRetrait->getCompteRetrai() === $this) {
                $compteRetrait->setCompteRetrai(null);
            }
        }

        return $this;
    }

}
