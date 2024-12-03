<?php

namespace App\Entity;

use App\Enum\RoleUserEnum;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("JOINED")] // Declare JOINED inheritance strategy
#[ORM\DiscriminatorColumn(name: "discr", type: "string")] // Discriminator column to differentiate subclasses
#[ORM\DiscriminatorMap([
    "user" => User::class, 
    "admin" => Admin::class, 
    "enseignant" => Enseignant::class, 
    "etudiant" => Etudiant::class
])]
#[Broadcast]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idUser = null;

    #[ORM\Column(length: 255)]
    private string $nomUser;

    #[ORM\Column(length: 255)]
    private string $prenomUser;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emailUser = null;

    #[ORM\Column(length: 255)]
    private string $motdepasseUser;

    #[ORM\Column]
    private int $numtelephoneUser;

    #[ORM\Column(type: 'string', enumType: RoleUserEnum::class)]
    private RoleUserEnum $roleUser = RoleUserEnum::STUDENT; // Default to STUDENT

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $datenaissanceUser;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photoUser = null;

    // Getters and Setters

    

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): static
    {
        $this->idUser = $idUser;
        return $this;
    }

    public function getNomUser(): string
    {
        return $this->nomUser;
    }

    public function setNomUser(string $nomUser): static
    {
        $this->nomUser = $nomUser;
        return $this;
    }

    public function getPrenomUser(): string
    {
        return $this->prenomUser;
    }

    public function setPrenomUser(string $prenomUser): static
    {
        $this->prenomUser = $prenomUser;
        return $this;
    }

    public function getEmailUser(): ?string
    {
        return $this->emailUser;
    }

    public function setEmailUser(?string $emailUser): static
    {
        $this->emailUser = $emailUser;
        return $this;
    }

    public function getMotdepasseUser(): string
    {
        return $this->motdepasseUser;
    }

    public function setMotdepasseUser(string $motdepasseUser): static
    {
        $this->motdepasseUser = $motdepasseUser;
        return $this;
    }

    public function getNumtelephoneUser(): int
    {
        return $this->numtelephoneUser;
    }

    public function setNumtelephoneUser(int $numtelephoneUser): static
    {
        $this->numtelephoneUser = $numtelephoneUser;
        return $this;
    }

    public function getRoleUser(): RoleUserEnum
    {
        return $this->roleUser;
    }

    public function setRoleUser(RoleUserEnum $roleUser): static
    {
        $this->roleUser = $roleUser;
        return $this;
    }

    public function getDatenaissanceUser(): \DateTimeInterface
    {
        return $this->datenaissanceUser;
    }

    public function setDatenaissanceUser(\DateTimeInterface $datenaissanceUser): static
    {
        $this->datenaissanceUser = $datenaissanceUser;
        return $this;
    }

    public function getPhotoUser(): ?string
    {
        return $this->photoUser;
    }

    public function setPhotoUser(?string $photoUser): static
    {
        $this->photoUser = $photoUser;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email; // You can use another unique field if required
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // Example: $this->plainPassword = null;
    }
}
