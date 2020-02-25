<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\RetraitController;
use App\Controller\TransactionController;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *  collectionOperations={
 *        "get"={
*                  "access_control"="is_granted('VIEW', object)",
 *              },
 *         "post"={
 *              "controller"=TransactionController::class,
 *             
 * }
 *     },
 *   itemOperations={
 *        "get"={"access_control"="is_granted('VIEW', object)",
 * 
 *      },
 *      "put"={
 *          "controller"=RetraitController::class,
 *     
 *      },
 * },)
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Regex("/^[a-zA-Z0-9_]+$/")
     * @ORM\Column(type="string", length=255)
     */
    private $nomC_Envoyeur;

    /**
     * @ORM\Column(type="integer")
     */
    private $CNI_Envoyeur;

    /**
     * @Assert\Regex(
     * pattern="#^7[0,6,7,8]([0-9]){7}$#",
     * message="Votre telephone n'est pas valide"
     * )
     * @ORM\Column(type="integer")
     */
    private $tel_Envoyeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     */
    private $montant;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $CNI_Envoye;

    /**
     * @Assert\Regex("/^[a-zA-Z0-9_]+$/")
     * @ORM\Column(type="string", length=255)
     */
    private $nomC_Envoye;

    /**
     * @Assert\Regex(
     * pattern="#^7[0,6,7,8]([0-9]){7}$#",
     * message="Votre telephone n'est pas valide"
     * )
     * @ORM\Column(type="integer")
     */
    private $tel_Envoye;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $frais;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactions")
     */
    private $retrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transfert")
     */
    private $transfert;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactions")
     */
    private $compte;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $partEtat;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $partSysteme;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $partEnvoyeur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $partRetreur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="compteRetrait")
     */
    private $compteRetrai;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $montantPercu;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;


    public function __construct()
    {
        $this->statut = true;

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCEnvoyeur(): ?string
    {
        return $this->nomC_Envoyeur;
    }

    public function setNomCEnvoyeur(string $nomC_Envoyeur): self
    {
        $this->nomC_Envoyeur = $nomC_Envoyeur;

        return $this;
    }

    public function getCNIEnvoyeur(): ?int
    {
        return $this->CNI_Envoyeur;
    }

    public function setCNIEnvoyeur(int $CNI_Envoyeur): self
    {
        $this->CNI_Envoyeur = $CNI_Envoyeur;

        return $this;
    }

    public function getTelEnvoyeur(): ?int
    {
        return $this->tel_Envoyeur;
    }

    public function setTelEnvoyeur(int $tel_Envoyeur): self
    {
        $this->tel_Envoyeur = $tel_Envoyeur;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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

    public function getCNIEnvoye(): ?int
    {
        return $this->CNI_Envoye;
    }

    public function setCNIEnvoye(?int $CNI_Envoye): self
    {
        $this->CNI_Envoye = $CNI_Envoye;

        return $this;
    }

    public function getNomCEnvoye(): ?string
    {
        return $this->nomC_Envoye;
    }

    public function setNomCEnvoye(string $nomC_Envoye): self
    {
        $this->nomC_Envoye = $nomC_Envoye;

        return $this;
    }

    public function getTelEnvoye(): ?int
    {
        return $this->tel_Envoye;
    }

    public function setTelEnvoye(int $tel_Envoye): self
    {
        $this->tel_Envoye = $tel_Envoye;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(?int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getRetrait(): ?User
    {
        return $this->retrait;
    }

    public function setRetrait(?User $retrait): self
    {
        $this->retrait = $retrait;

        return $this;
    }

    public function getTransfert(): ?User
    {
        return $this->transfert;
    }

    public function setTransfert(?User $transfert): self
    {
        $this->transfert = $transfert;

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

    public function getPartEtat(): ?int
    {
        return $this->partEtat;
    }

    public function setPartEtat(?int $partEtat): self
    {
        $this->partEtat = $partEtat;

        return $this;
    }

    public function getPartSysteme(): ?int
    {
        return $this->partSysteme;
    }

    public function setPartSysteme(?int $partSysteme): self
    {
        $this->partSysteme = $partSysteme;

        return $this;
    }

    public function getPartEnvoyeur(): ?int
    {
        return $this->partEnvoyeur;
    }

    public function setPartEnvoyeur(?int $partEnvoyeur): self
    {
        $this->partEnvoyeur = $partEnvoyeur;

        return $this;
    }

    public function getPartRetreur(): ?int
    {
        return $this->partRetreur;
    }

    public function setPartRetreur(?int $partRetreur): self
    {
        $this->partRetreur = $partRetreur;

        return $this;
    }

    public function getCompteRetrai(): ?Compte
    {
        return $this->compteRetrai;
    }

    public function setCompteRetrai(?Compte $compteRetrai): self
    {
        $this->compteRetrai = $compteRetrai;

        return $this;
    }

    public function getMontantPercu(): ?int
    {
        return $this->montantPercu;
    }

    public function setMontantPercu(?int $montantPercu): self
    {
        $this->montantPercu = $montantPercu;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

}
