<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\BlagController;
use App\Controller\BlogController;
use App\Controller\UserController;
use App\Controller\ImageController;
use App\Controller\StatuController;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ApiResource(
 *  collectionOperations={
 *
 *        "get"={
 *               "controller"=BlagController::class,
 *              },
 *         "post"={
 *             
 *              "controller"=UserController::class
 * }
 *     },
 *   itemOperations={
 *    "bloquer"={
 *      "method"="PUT",
 *      "path"="/bloqueUser/{id}",
 *      "normalization_context"={"groups"={"write"}},
 *      "controller"=StatuController::class,
 * },
 *        "get"={"access_control"="is_granted('VIEW', object)",
 *          "controller"=BlogController::class,
 *         
 *      },
 *      "put"={
 *          "access_control"="is_granted('EDIT', object)",
 *          "normalization_context"={"groups"={"write"}},
 * },
 *     "delete"={
 *          "access_control"="is_granted('EDIT', object)",
 * },          
 *  "mo_image"={
 *      "method"="post",
 *         "path"="/users/image/{id}",
 *             "controller"=ImageController::class,
 *              "normalization_context"={"groups"={"write"}},
 *             "deserialize"=false,
 *             "openapi_context"={
 *                 "requestBody"={
 *                     "content"={
 *                         "multipart/form-data"={
 *                             "schema"={
 *                                 "type"="object",
 *                                 "properties"={
 *                                     "file"={
 *                                         "type"="string",
 *                                         "format"="binary"
 *                                     }
 *                                 }
 *                             }
 *                         }
 *                     }
 *                 }
 *             }
 *         }
 * },  
 *    
 *     )
 * @UniqueEntity(
 * fields={"username"},
 *  message="username déjà utilisé.")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"read","write"})
     * @Assert\Regex("/^[a-zA-Z0-9_]+$/")
     * @ORM\Column(type="string", length=180, unique=true)
     * 
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"read", "write"})
     */
    private $password;

    /**
     * @Groups({"read","write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     */
    private $role;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read", "write"})
     */
    private $isActive;

    /**
     * @Assert\Regex("/^[a-zA-Z0-9_]+$/")
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "write"})
     */
    private $nomComplet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="users")
     */
    private $partenaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="retrait")
     */
    private $transactions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="transfert")
     */
    private $transfert;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Affectation", mappedBy="user")
     */
    private $affectations;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $image;

    private $decodedData;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Affectation", mappedBy="user")
     */
    private $affecteurs;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->transfert = new ArrayCollection();
        $this->affectations = new ArrayCollection();
        $this->affecteurs = new ArrayCollection();
        $this->depots = new ArrayCollection();
        $this->isActive = true;
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return[ $this->role->getLibelle()];
        //$this->roles = 'ROLE_'.strtoupper($this->role->getLibelle());
        // guarantee every user at least has ROLE_USER
       // return array($this->roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

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
            $transaction->setRetrait($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getRetrait() === $this) {
                $transaction->setRetrait(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransfert(): Collection
    {
        return $this->transfert;
    }

    public function addTransfert(Transaction $transfert): self
    {
        if (!$this->transfert->contains($transfert)) {
            $this->transfert[] = $transfert;
            $transfert->setTransfert($this);
        }

        return $this;
    }

    public function removeTransfert(Transaction $transfert): self
    {
        if ($this->transfert->contains($transfert)) {
            $this->transfert->removeElement($transfert);
            // set the owning side to null (unless already changed)
            if ($transfert->getTransfert() === $this) {
                $transfert->setTransfert(null);
            }
        }

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
            $affectation->setUser($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): self
    {
        if ($this->affectations->contains($affectation)) {
            $this->affectations->removeElement($affectation);
            // set the owning side to null (unless already changed)
            if ($affectation->getUser() === $this) {
                $affectation->setUser(null);
            }
        }

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;
        $this->decodedData = base64_decode($image);


        return $this;
    }

    /**
     * @return Collection|Affectation[]
     */
    public function getAffecteurs(): Collection
    {
        return $this->affecteurs;
    }

    public function addAffecteur(Affectation $affecteur): self
    {
        if (!$this->affecteurs->contains($affecteur)) {
            $this->affecteurs[] = $affecteur;
            $affecteur->setUserAffect($this);
        }

        return $this;
    }

    public function removeAffecteur(Affectation $affecteur): self
    {
        if ($this->affecteurs->contains($affecteur)) {
            $this->affecteurs->removeElement($affecteur);
            // set the owning side to null (unless already changed)
            if ($affecteur->getUserAffect() === $this) {
                $affecteur->setUserAffect(null);
            }
        }

        return $this;
    }

}