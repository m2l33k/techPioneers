<?php

namespace App\Entity;

use App\Enum\Role_UserEnum;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("JOINED")] // Déclare la stratégie d'héritage JOINED
#[ORM\DiscriminatorColumn(name: "discr", type: "string")] // Colonne discriminante pour différencier les sous-classes
#[ORM\DiscriminatorMap([
    "user" => User::class, 
    "admin" => Admin::class, 
    "enseignant" => Enseignant::class, // Ajout d'Enseignant
    "etudiant" => Etudiant::class // Ajout d'Etudiant
])]
#[Broadcast]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $Id_user; // Non nullable

    #[ORM\Column(length: 255)]
    private string $Nom_user; // Non nullable

    #[ORM\Column(length: 255)]
    private string $Prenom_user; // Non nullable

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Email_user = null; // Nullable

    #[ORM\Column(length: 255)]
    private string $Motdepasse_user; // Non nullable

    #[ORM\Column]
    private int $Numtelephone_user; // Non nullable

    #[ORM\Column(type: 'string', enumType: Role_UserEnum::class)]
    private Role_UserEnum $Role_user; // Non nullable

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $Datenaissance_user; // Non nullable

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Photo_user = null; // Nullable

    // Getters and Setters

    public function getIdUser(): int
    {
        return $this->Id_user;
    }

    public function setIdUser(int $Id_user): static
    {
        $this->Id_user = $Id_user;
        return $this;
    }

    public function getNomUser(): string
    {
        return $this->Nom_user;
    }

    public function setNomUser(string $Nom_user): static
    {
        $this->Nom_user = $Nom_user;
        return $this;
    }

    public function getPrenomUser(): string
    {
        return $this->Prenom_user;
    }

    public function setPrenomUser(string $Prenom_user): static
    {
        $this->Prenom_user = $Prenom_user;
        return $this;
    }

    public function getEmailUser(): ?string
    {
        return $this->Email_user;
    }

    public function setEmailUser(?string $Email_user): static
    {
        $this->Email_user = $Email_user;
        return $this;
    }

    public function getMotdepasseUser(): string
    {
        return $this->Motdepasse_user;
    }

    public function setMotdepasseUser(string $Motdepasse_user): static
    {
        $this->Motdepasse_user = $Motdepasse_user;
        return $this;
    }

    public function getNumtelephoneUser(): int
    {
        return $this->Numtelephone_user;
    }

    public function setNumtelephoneUser(int $Numtelephone_user): static
    {
        $this->Numtelephone_user = $Numtelephone_user;
        return $this;
    }

    public function getRoleUser(): Role_UserEnum
    {
        return $this->Role_user;
    }

    public function setRoleUser(Role_UserEnum $Role_user): static
    {
        $this->Role_user = $Role_user;
        return $this;
    }

    public function getDatenaissanceUser(): \DateTimeInterface
    {
        return $this->Datenaissance_user;
    }

    public function setDatenaissanceUser(\DateTimeInterface $Datenaissance_user): static
    {
        $this->Datenaissance_user = $Datenaissance_user;
        return $this;
    }

    public function getPhotoUser(): ?string
    {
        return $this->Photo_user;
    }

    public function setPhotoUser(?string $Photo_user): static
    {
        $this->Photo_user = $Photo_user;
        return $this;
    }
}
