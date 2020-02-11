<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
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
     * @ORM\Column(type="string", length=255)
     */
    private $nomC_Envoyeur;

    /**
     * @ORM\Column(type="integer")
     */
    private $CNI_Envoyeur;

    /**
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
    private $CNI_Envoyé;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomC_Envoyé;

    /**
     * @ORM\Column(type="integer")
     */
    private $tel_Envoyé;

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

    public function getCNIEnvoyé(): ?int
    {
        return $this->CNI_Envoyé;
    }

    public function setCNIEnvoyé(?int $CNI_Envoyé): self
    {
        $this->CNI_Envoyé = $CNI_Envoyé;

        return $this;
    }

    public function getNomCEnvoyé(): ?string
    {
        return $this->nomC_Envoyé;
    }

    public function setNomCEnvoyé(string $nomC_Envoyé): self
    {
        $this->nomC_Envoyé = $nomC_Envoyé;

        return $this;
    }

    public function getTelEnvoyé(): ?int
    {
        return $this->tel_Envoyé;
    }

    public function setTelEnvoyé(int $tel_Envoyé): self
    {
        $this->tel_Envoyé = $tel_Envoyé;

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
}
