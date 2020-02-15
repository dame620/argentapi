<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * 
 * normalizationContext={"groups"={"read"}},
 * denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ContratRepository")
 */
class Contrat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="text",nullable=true)
     */
    private $terme;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Partenaire", mappedBy="contrat", cascade={"persist", "remove"})
     */
    private $partenaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTerme(): ?string
    {
        return $this->terme;
    }

    public function setTerme(?string $terme): self
    {
        $this->terme = $terme;

        return $this;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

        // set (or unset) the owning side of the relation if necessary
        $newContrat = null === $partenaire ? null : $this;
        if ($partenaire->getContrat() !== $newContrat) {
            $partenaire->setContrat($newContrat);
        }

        return $this;
    }
}
