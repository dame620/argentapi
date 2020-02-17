<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\AffectationController;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 * collectionOperations={
 * "POST"={
 *     "controller"=AffectationController::class,
 *      "access_control"="is_granted('POST', object)",  
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
 *     "controller"=AffectationController::class,
 *      "access_control"="is_granted('EDIT', object)",  
 *     
 * },
 * }
 * )
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
     * @ORM\Column(type="date", nullable=true)
     */
    private $datedebut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datefin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="affectations")
     */
    private $compte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="affectations")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="secondaffectations")
     */
    private $useraffecteur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(?\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(?\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUseraffecteur(): ?User
    {
        return $this->useraffecteur;
    }

    public function setUseraffecteur(?User $useraffecteur): self
    {
        $this->useraffecteur = $useraffecteur;

        return $this;
    }
}
