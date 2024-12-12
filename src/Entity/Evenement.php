<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[ORM\Table(name: "evenement")]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idEvenement", type: "integer")]
    private int $idEvenement;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le titre de l'événement est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le titre de l'événement ne peut pas dépasser {{ limit }} caractères."
    )]
    private string $Titre_Evenement;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotNull(message: "La date de l'événement est obligatoire.")]
    #[Assert\Type(
        type: \DateTimeInterface::class,
        message: "La date doit être une date valide."
    )]
    private \DateTimeInterface $Date_Evenement;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: "La description de l'événement est obligatoire.")]
    private string $Description_Evenement;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'organisateur est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le nom de l'organisateur ne peut pas dépasser {{ limit }} caractères."
    )]
    private string $Organisateur_Evenement;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le lien de l'événement est obligatoire.")]
    #[Assert\Url(message: "Le lien doit être une URL valide.")]
    private string $lien_Evenement;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le lieu de l'événement ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $Lieu_Evenement = null;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: "idCategory", referencedColumnName: "idCategory", nullable: false)]
    #[Assert\NotNull(message: "La catégorie de l'événement est obligatoire.")]
    private Category $category;

    // Getters et Setters

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

    public function getLieuEvenement(): ?string
    {
        return $this->Lieu_Evenement;
    }

    public function setLieuEvenement(?string $Lieu_Evenement): static
    {
        $this->Lieu_Evenement = $Lieu_Evenement;
        return $this;
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
}
