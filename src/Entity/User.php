<?php

namespace App\Entity;

use App\Enum\RoleUserEnum;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

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
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $idUser;

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

    public function getIdUser(): int
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
}
