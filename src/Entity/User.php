<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\UserController;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ApiResource(
 *  collectionOperations={
 *        "get"={
*                  "access_control"="is_granted('VIEW', object)",
 *              },
 *         "post"={
 *             "access_control"="is_granted('ADD', object)",
 *              "controller"=UserController::class
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
 * },
 *      
 *     
 * 
 * )
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
     * 
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"read","write"})
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * @Groups({"read","write"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"read","write"})
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"read","write"})
     */
    private $role;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read","write"})
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read","write"})
     */
    private $nomComplet;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read","write"})
     */
    private $profil;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="users", cascade={"persist"})
     */
    private $partenaire;

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
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER

        return $roles;
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

    public function getProfil(): ?string
    {
        return $this->profil;
    }

    public function setProfil(string $profil): self
    {
        $this->profil = $profil;

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

}
