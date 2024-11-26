<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "Id_Cours", type: "integer")]
    private int $Id_Cours;
    

    #[ORM\Column(length: 255)]
    private string $Titre_Cours;

    #[ORM\Column(type: 'text')]
    private string $Descriptio_Cours;

    #[ORM\Column]
    private int $Id_Enseignant_Cours;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $Date_creation_Cours;

    // Getters and Setters

    public function getIdCours(): int
    {
        return $this->Id_Cours;
    }

    public function setIdCours(int $Id_Cours): static
    {
        $this->Id_Cours = $Id_Cours;
        return $this;
    }

    public function getTitreCours(): string
    {
        return $this->Titre_Cours;
    }

    public function setTitreCours(string $Titre_Cours): static
    {
        $this->Titre_Cours = $Titre_Cours;
        return $this;
    }

    public function getDescriptioCours(): string
    {
        return $this->Descriptio_Cours;
    }

    public function setDescriptioCours(string $Descriptio_Cours): static
    {
        $this->Descriptio_Cours = $Descriptio_Cours;
        return $this;
    }

    public function getIdEnseignantCours(): int
    {
        return $this->Id_Enseignant_Cours;
    }

    public function setIdEnseignantCours(int $Id_Enseignant_Cours): static
    {
        $this->Id_Enseignant_Cours = $Id_Enseignant_Cours;
        return $this;
    }

    public function getDateCreationCours(): \DateTimeInterface
    {
        return $this->Date_creation_Cours;
    }

    public function setDateCreationCours(\DateTimeInterface $Date_creation_Cours): static
    {
        $this->Date_creation_Cours = $Date_creation_Cours;
        return $this;
    }

    public function __toString(): string
    {
    return $this->Titre_Cours; 
    }
}
