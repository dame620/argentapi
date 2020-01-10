<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ApiResource(
 * 
 * collectionOperations={
 * 
 * 
 * "creationadmin"={
 *     "method"="POST",
 *     "path"="ADMIN/CREATION",
 *     "access_control"="has_role('ROLE_SUPADMIN')"
 *      },
 * 
 * "recuperationadmin"={
 *      "method"="GET",
 *      "path"="ADMIN/SHOW",
 *      "access_control"="has_role('ROLE_SUPADMIN')"
 * },
 * 
 *},
 * 
 * itemOperations={
 *    
 *     "recuperationadmin"={
 *         "method"="GET",
 *         "path"="ADMIN/SHOW/{id}",
 *         "access_control"="has_role('ROLE_SUPADMIN')"
 *     },
 * 
 * "modificationnadmin"={
 *         "method"="PUT",
 *         "path"="ADMIN/MODIFIER/{id}",
 *         "access_control"="has_role('ROLE_SUPADMIN')"
 *     },
 * 
 * "modificationcaissier"={
 *         "method"="PUT",
 *         "path"="CAISSIER/MODIFIER/{id}",
 *         "access_control"="is_granted('ROLE_SUPADMIN', 'ROLE_ADMIN')",
 *         "access_control_message"="seul les supadmin et les admin sont autorisés a modifier un caissier"
 *     },
 * 
 *     "recuperatincaissier"={
 *         "method"="GET",
 *         "path"="ADMIN/SHOW/{id}",
 *          "access_control"="is_granted('ROLE_SUPADMIN', 'ROLE_ADMIN')", 
 *   "access_control_message"="seul les supadmin et les admin sont autorisés a modifier un caissier"
 *  },
 * 
 * }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements AdvancedUserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomcomplet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     */
    private $role;

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
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        

        return array_unique($roles);
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

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
    
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }
    
}
