<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Category;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[ORM\Table(name: "evenement")]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idEvenement", type: "integer")]
    private int $idEvenement;

    #[ORM\Column(length: 255)]
    private string $Titre_Evenement; // Non null

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $Date_Evenement; // Non null

    #[ORM\Column(type: 'text')]
    private string $Description_Evenement; // Non null

    #[ORM\Column(length: 255)]
    private string $Organisateur_Evenement; // Non null

    #[ORM\Column(length: 255)]
    private string $lien_Evenement; // Non null

    #[ORM\Column(length: 255)]
    private string $Lieu_Evenement;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: "idCategory", referencedColumnName: "idCategory", nullable: false)]
    private Category $category;

    public function getIdCategory(): int
    {
        return $this->idCategory;
    }
    
    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function getId(): int
    {
        return $this->getIdEvenement();
    }
    public function getIdEvenement(): int
    {
        return $this->idEvenement;
    }
    
    public function setIdEvenement(int $idEvenement): static
    {
        $this->idEvenement = $idEvenement;
        return $this;
    }

    public function getTitreEvenement(): string
    {
        return $this->Titre_Evenement;
    }

    public function setTitreEvenement(string $Titre_Evenement): static
    {
        $this->Titre_Evenement = $Titre_Evenement;
        return $this;
    }

    public function getDateEvenement(): \DateTimeInterface
    {
        return $this->Date_Evenement;
    }

    public function setDateEvenement(\DateTimeInterface $Date_Evenement): static
    {
        $this->Date_Evenement = $Date_Evenement;
        return $this;
    }

    public function getDescriptionEvenement(): string
    {
        return $this->Description_Evenement;
    }

    public function setDescriptionEvenement(string $Description_Evenement): static
    {
        $this->Description_Evenement = $Description_Evenement;
        return $this;
    }

    public function getOrganisateurEvenement(): string
    {
        return $this->Organisateur_Evenement;
    }

    public function setOrganisateurEvenement(string $Organisateur_Evenement): static
    {
        $this->Organisateur_Evenement = $Organisateur_Evenement;
        return $this;
    }

    public function getLienEvenement(): string
    {
        return $this->lien_Evenement;
    }

    public function setLienEvenement(string $lien_Evenement): static
    {
        $this->lien_Evenement = $lien_Evenement;
        return $this;
    }

    public function getLieuEvenement(): string
    {
        return $this->Lieu_Evenement;
    }

    public function setLieuEvenement(string $Lieu_Evenement): static
    {
        $this->Lieu_Evenement = $Lieu_Evenement;
        return $this;
    }
}
