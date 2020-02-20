<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\FraiRepository")
 */
class Frai
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
    private $borneinf;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bornesup;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $valeurfrai;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $grilleclient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorneinf(): ?int
    {
        return $this->borneinf;
    }

    public function setBorneinf(?int $borneinf): self
    {
        $this->borneinf = $borneinf;

        return $this;
    }

    public function getBornesup(): ?int
    {
        return $this->bornesup;
    }

    public function setBornesup(?int $bornesup): self
    {
        $this->bornesup = $bornesup;

        return $this;
    }

    public function getValeurfrai(): ?int
    {
        return $this->valeurfrai;
    }

    public function setValeurfrai(?int $valeurfrai): self
    {
        $this->valeurfrai = $valeurfrai;

        return $this;
    }

    public function getGrilleclient(): ?int
    {
        return $this->grilleclient;
    }

    public function setGrilleclient(?int $grilleclient): self
    {
        $this->grilleclient = $grilleclient;

        return $this;
    }
}
