<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: "category")]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idCategory", type: "integer")]
    private int $idCategory;

    #[ORM\Column(name: "nomCategory", type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le nom de la catégorie ne peut pas être vide.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le nom de la catégorie ne doit pas dépasser {{ limit }} caractères."
    )]
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
