<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\TransactionController;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 * collectionOperations={
 * "POST"={
 *     "controller"=TransactionController::class,
 *    
 *     
 *      },
 * 
 * "GETALL"={
 * "method"="GET",
 *   }
 * },
 * 
 * itemOperations={
 *    
 * "recuperation"={
 *      "method"="GET",
 * },
 * 
 * "PUT"={
 *     "controller"=TransactionController::class,
 *     "access_control"="is_granted('EDIT', object)", 
 *         
 * },
 * }
 * )
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $montanttransaction;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomdestinataire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomemmeteur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telemetteur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $teldestinataire;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $frais;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $partenvoyeur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $partretrait;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $partsysteme;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $partetat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactionenvois")
     */
    private $compteenvoi;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactionretraits")
     */
    private $compteretrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactionenvois")
     */
    private $userenvoi;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactionretraits")
     */
    private $userretrait;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cniemetteur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cnidestanataire;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $statu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontanttransaction(): ?int
    {
        return $this->montanttransaction;
    }

    public function setMontanttransaction(?int $montanttransaction): self
    {
        $this->montanttransaction = $montanttransaction;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNomdestinataire(): ?string
    {
        return $this->nomdestinataire;
    }

    public function setNomdestinataire(?string $nomdestinataire): self
    {
        $this->nomdestinataire = $nomdestinataire;

        return $this;
    }

    public function getNomemmeteur(): ?string
    {
        return $this->nomemmeteur;
    }

    public function setNomemmeteur(?string $nomemmeteur): self
    {
        $this->nomemmeteur = $nomemmeteur;

        return $this;
    }

    public function getTelemetteur(): ?int
    {
        return $this->telemetteur;
    }

    public function setTelemetteur(?int $telemetteur): self
    {
        $this->telemetteur = $telemetteur;

        return $this;
    }

    public function getTeldestinataire(): ?int
    {
        return $this->teldestinataire;
    }

    public function setTeldestinataire(?int $teldestinataire): self
    {
        $this->teldestinataire = $teldestinataire;

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

    public function getPartenvoyeur(): ?int
    {
        return $this->partenvoyeur;
    }

    public function setPartenvoyeur(?int $partenvoyeur): self
    {
        $this->partenvoyeur = $partenvoyeur;

        return $this;
    }

    public function getPartretrait(): ?int
    {
        return $this->partretrait;
    }

    public function setPartretrait(?int $partretrait): self
    {
        $this->partretrait = $partretrait;

        return $this;
    }

    public function getPartsysteme(): ?int
    {
        return $this->partsysteme;
    }

    public function setPartsysteme(?int $partsysteme): self
    {
        $this->partsysteme = $partsysteme;

        return $this;
    }

    public function getPartetat(): ?int
    {
        return $this->partetat;
    }

    public function setPartetat(?int $partetat): self
    {
        $this->partetat = $partetat;

        return $this;
    }

    public function getCompteenvoi(): ?Compte
    {
        return $this->compteenvoi;
    }

    public function setCompteenvoi(?Compte $compteenvoi): self
    {
        $this->compteenvoi = $compteenvoi;

        return $this;
    }

    public function getCompteretrait(): ?Compte
    {
        return $this->compteretrait;
    }

    public function setCompteretrait(?Compte $compteretrait): self
    {
        $this->compteretrait = $compteretrait;

        return $this;
    }

    public function getUserenvoi(): ?User
    {
        return $this->userenvoi;
    }

    public function setUserenvoi(?User $userenvoi): self
    {
        $this->userenvoi = $userenvoi;

        return $this;
    }

    public function getUserretrait(): ?User
    {
        return $this->userretrait;
    }

    public function setUserretrait(?User $userretrait): self
    {
        $this->userretrait = $userretrait;

        return $this;
    }

    public function getCniemetteur(): ?int
    {
        return $this->cniemetteur;
    }

    public function setCniemetteur(?int $cniemetteur): self
    {
        $this->cniemetteur = $cniemetteur;

        return $this;
    }

    public function getCnidestanataire(): ?int
    {
        return $this->cnidestanataire;
    }

    public function setCnidestanataire(?int $cnidestanataire): self
    {
        $this->cnidestanataire = $cnidestanataire;

        return $this;
    }

    public function getStatu(): ?bool
    {
        return $this->statu;
    }

    public function setStatu(?bool $statu): self
    {
        $this->statu = $statu;

        return $this;
    }
}
