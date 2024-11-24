<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnseignantRepository::class)]
class Enseignant extends User
{
    #[ORM\Column(length: 255)]
    private string $Spécialite_Enseignant; // Non null

    #[ORM\Column(length: 255)]
    private string $Departement_Enseignant; // Non null

    #[ORM\Column(length: 255)]
    private string $Etat_Enseignant; // Non null

    // Getters and Setters

    public function getSpécialiteEnseignant(): string
    {
        return $this->Spécialite_Enseignant;
    }

    public function setSpécialiteEnseignant(string $Spécialite_Enseignant): static
    {
        $this->Spécialite_Enseignant = $Spécialite_Enseignant;
        return $this;
    }

    public function getDepartementEnseignant(): string
    {
        return $this->Departement_Enseignant;
    }

    public function setDepartementEnseignant(string $Departement_Enseignant): static
    {
        $this->Departement_Enseignant = $Departement_Enseignant;
        return $this;
    }

    public function getEtatEnseignant(): string
    {
        return $this->Etat_Enseignant;
    }

    public function setEtatEnseignant(string $Etat_Enseignant): static
    {
        $this->Etat_Enseignant = $Etat_Enseignant;
        return $this;
    }
}
