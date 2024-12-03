<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "category")]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idCategory", type: "integer")]
    private int $idCategory;

    #[ORM\Column(name: "nomCategory", type: "string", length: 255)]
    private string $nomCategory;

    public function getIdCategory(): int
    {
        return $this->idCategory;
    }

    public function getNomCategory(): string
    {
        return $this->nomCategory;
    }

    public function setNomCategory(string $nomCategory): static
    {
        $this->nomCategory = $nomCategory;
        return $this;
    }
}

