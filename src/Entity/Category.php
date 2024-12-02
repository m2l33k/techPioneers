<?php

namespace App\Entity;

use App\Entity\Evenement;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "Id_category", type: "integer")]
    private ?int $idCategory = null;

    #[ORM\Column(length: 255)]
    private string $nomCategory;

    #[ORM\ManyToOne(targetEntity: Evenement::class)]
    #[ORM\JoinColumn(name: "idEvenement", referencedColumnName: "idEvenement", nullable: false)]
    private Evenement $evenement;

    public function getIdEvenement(): ?int
    {
        return $this->evenement->getidEvenement();
    }
    public function getEvenement(): Evenement
    {
        return $this->evenement;
    }
    
    public function setEvenement(Evenement $evenement): self
    {
        $this->evenement = $evenement;
        return $this;
    }

    public function getIdCategory(): ?int
    {
        return $this->idCategory;
    }

    public function setIdCategory(?int $idCategory): self
    {
        $this->idCategory = $idCategory;
        return $this;
    }

    public function getNomCategory(): string
    {
        return $this->nomCategory;
    }

    public function setNomCategory(string $nomCategory): self
    {
        $this->nomCategory = $nomCategory;
        return $this;
    }


}

