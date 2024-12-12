<?php

namespace App\Entity;

use App\Enum\TypeRessourceEnum;
use App\Repository\RessourceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: RessourceRepository::class)]
#[Broadcast]
class Ressource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $Id_Ressource;

    #[ORM\Column(length: 255)]
    private string $Titre_Ressource;

    #[ORM\Column(length: 800)]
    private string $Description_Ressource;

    #[ORM\Column(type: 'string', enumType: TypeRessourceEnum::class)]
    private TypeRessourceEnum $Type_Ressource;

    #[ORM\Column]
    private int $Id_Enseignat_Ressource;

    #[ORM\Column(length: 255)]
    private string $Url_Ressource;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $DateCreation_Ressource;

    #[ORM\ManyToOne(targetEntity: Cours::class)]
    #[ORM\JoinColumn(name: "Id_Cours", referencedColumnName: "Id_Cours", nullable: false)]
    private Cours $Id_Cours;

    

    public function getIdRessource(): int
    {
        return $this->Id_Ressource;
    }

    public function setIdRessource(int $Id_Ressource): static
    {
        $this->Id_Ressource = $Id_Ressource;
        return $this;
    }

    public function getTitreRessource(): string
    {
        return $this->Titre_Ressource;
    }

    public function setTitreRessource(string $Titre_Ressource): static
    {
        $this->Titre_Ressource = $Titre_Ressource;
        return $this;
    }

    public function getDescriptionRessource(): string
    {
        return $this->Description_Ressource;
    }

    public function setDescriptionRessource(string $Description_Ressource): static
    {
        $this->Description_Ressource = $Description_Ressource;
        return $this;
    }

    public function getTypeRessource(): TypeRessourceEnum
    {
        return $this->Type_Ressource;
    }

    public function setTypeRessource(TypeRessourceEnum $Type_Ressource): static
    {
        $this->Type_Ressource = $Type_Ressource;
        return $this;
    }

    public function getIdEnseignatRessource(): int
    {
        return $this->Id_Enseignat_Ressource;
    }

    public function setIdEnseignatRessource(int $Id_Enseignat_Ressource): static
    {
        $this->Id_Enseignat_Ressource = $Id_Enseignat_Ressource;
        return $this;
    }

    public function getUrlRessource(): string
    {
        return $this->Url_Ressource;
    }

    public function setUrlRessource(string $Url_Ressource): static
    {
        $this->Url_Ressource = $Url_Ressource;
        return $this;
    }

    public function getDateCreationRessource(): \DateTimeInterface
    {
        return $this->DateCreation_Ressource;
    }

    public function setDateCreationRessource(\DateTimeInterface $DateCreation_Ressource): static
    {
        $this->DateCreation_Ressource = $DateCreation_Ressource;
        return $this;
    }
    public function getId(): int
    {
        return $this->getIdCours();
    }
    public function getIdCours(): Cours
    {
        return $this->Id_Cours;
    }
    
    public function setIdCours(Cours $Id_Cours): static
    {
        $this->Id_Cours = $Id_Cours;
        return $this;
    }
    
}
