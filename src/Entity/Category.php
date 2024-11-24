<?php

namespace App\Entity;

use App\Entity\Evenement;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $Id_category;

    #[ORM\Column(length: 255)]
    private string $Nom_Category;

    #[ORM\ManyToOne(targetEntity: Evenement::class)]
    #[ORM\JoinColumn(name: "Id_Evenement", referencedColumnName: "Id_Evenement", nullable: false)]
    private Evenement $evenement;

    // Getters and Setters

    public function getIdCategory(): int
    {
        return $this->Id_category;
    }

    public function setIdCategory(int $Id_category): static
    {
        $this->Id_category = $Id_category;
        return $this;
    }

    public function getNomCategory(): string
    {
        return $this->Nom_Category;
    }

    public function setNomCategory(string $Nom_Category): static
    {
        $this->Nom_Category = $Nom_Category;
        return $this;
    }

    public function getEvenement(): Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(Evenement $evenement): static
    {
        $this->evenement = $evenement;
        return $this;
    }
}
