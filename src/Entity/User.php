<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\UserController;
use App\Controller\ImageController;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;


/**
 * @ApiFilter(BooleanFilter::class, properties={"isActive"})
 * @ApiResource(
 * 
 *  normalizationContext={
 *         "groups"={"media_object_read"}
 *     },
 * 
 * collectionOperations={
 * 
 * 
 * "POST"={
 *    "access_control"="is_granted('POST', object)",
 *    "controller"=UserController::class,
 * 
 *      },
 * 
 * "GETALLUSER"={
 * "method"="GET",
 *
 *   }
 * },
 * 
 * itemOperations={
 *    
 * "recuperationadmin"={
 *      "method"="GET",
 *      
 * },
 * 
 * "PUT"={
 *      "access_control"="is_granted('EDIT', object)",
 *       "controller"=ImageController::class,
 *        "deserialize"=false,
 *   "validation_groups"={"Default", "media_object_create"},
 *  "openapi_context"={
 *                 "requestBody"={
 *                     "content"={
 *                         "multipart/form-data"={
 *                             "schema"={
 *                                 "type"="object",
 *                                 "properties"={
 *                                     "file"={
 *                                         "type"="string",
 *                                         "format"="binary"
 *                                    }
 *                                 }
 *                             }
 *                         }
 *                     }
 *                 }
 *              }
 *    
 * },
 * }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * 
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=180, unique=true)
     * 
     */
    private $username;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="json")
     * 
     */
    private $roles = [];

    /**
     * @Groups({"read", "write"})
     * @var string The hashed password
     * @ORM\Column(type="string")
     * 
     */
    private $password;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"read", "write"})
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read", "write"})
     */
    private $nomcomplet;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     * 
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="user")
     */
    private $depots;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="user")
     */
    private $comptes;

    

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="users")
     * 
     */
    private $partenaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Affectation", mappedBy="user")
     */
    private $affectations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Affectation", mappedBy="useraffecteur")
     */
    private $secondaffectations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="userenvoi")
     */
    private $transactionenvois;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="userretrait")
     */
    private $transactionretraits;


    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->comptes = new ArrayCollection();
        $this->affectations = new ArrayCollection();
        $this->secondaffectations = new ArrayCollection();
        $this->transactionenvois = new ArrayCollection();
        $this->transactionretraits = new ArrayCollection();
       /* $this->roles = array(
            'ROLE'.strtoupper($this->getRole()->getLibelle())
        );*/
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
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
     
        return ["ROLE_".$this->role->getLibelle()];
    }
/*
    public function getRoles(): array
    {
        $this->roles = 'ROLE_'.strtoupper($this->getRole()->getLibelle());
        // guarantee every user at least has ROLE_USER
        $roles = $this-> roles;
        return array($roles);
       // return array_unique($roles);
    }
*/

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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getNomcomplet(): ?string
    {
        return $this->nomcomplet;
    }

    public function setNomcomplet(?string $nomcomplet): self
    {
        $this->nomcomplet = $nomcomplet;

        return $this;
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

    /**
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
            $depot->setUser($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getUser() === $this) {
                $depot->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Compte[]
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->setUser($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->contains($compte)) {
            $this->comptes->removeElement($compte);
            // set the owning side to null (unless already changed)
            if ($compte->getUser() === $this) {
                $compte->setUser(null);
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

    /**
     * @return Collection|Affectation[]
     */
    public function getSecondaffectations(): Collection
    {
        return $this->secondaffectations;
    }

    public function addSecondaffectation(Affectation $secondaffectation): self
    {
        if (!$this->secondaffectations->contains($secondaffectation)) {
            $this->secondaffectations[] = $secondaffectation;
            $secondaffectation->setUseraffecteur($this);
        }

        return $this;
    }

    public function removeSecondaffectation(Affectation $secondaffectation): self
    {
        if ($this->secondaffectations->contains($secondaffectation)) {
            $this->secondaffectations->removeElement($secondaffectation);
            // set the owning side to null (unless already changed)
            if ($secondaffectation->getUseraffecteur() === $this) {
                $secondaffectation->setUseraffecteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactionenvois(): Collection
    {
        return $this->transactionenvois;
    }

    public function addTransactionenvois(Transaction $transactionenvois): self
    {
        if (!$this->transactionenvois->contains($transactionenvois)) {
            $this->transactionenvois[] = $transactionenvois;
            $transactionenvois->setUserenvoi($this);
        }

        return $this;
    }

    public function removeTransactionenvois(Transaction $transactionenvois): self
    {
        if ($this->transactionenvois->contains($transactionenvois)) {
            $this->transactionenvois->removeElement($transactionenvois);
            // set the owning side to null (unless already changed)
            if ($transactionenvois->getUserenvoi() === $this) {
                $transactionenvois->setUserenvoi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactionretraits(): Collection
    {
        return $this->transactionretraits;
    }

    public function addTransactionretrait(Transaction $transactionretrait): self
    {
        if (!$this->transactionretraits->contains($transactionretrait)) {
            $this->transactionretraits[] = $transactionretrait;
            $transactionretrait->setUserretrait($this);
        }

        return $this;
    }

    public function removeTransactionretrait(Transaction $transactionretrait): self
    {
        if ($this->transactionretraits->contains($transactionretrait)) {
            $this->transactionretraits->removeElement($transactionretrait);
            // set the owning side to null (unless already changed)
            if ($transactionretrait->getUserretrait() === $this) {
                $transactionretrait->setUserretrait(null);
            }
        }

        return $this;
    }




}
