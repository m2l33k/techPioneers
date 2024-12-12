<?php

namespace App\Entity;

use App\Repository\ForumRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForumRepository::class)]
class Forum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $Id_Forum; // Non null

    #[ORM\Column(length: 255)]
    private string $Titre_Forum; // Non null

    #[ORM\Column(type: 'text')]
    private string $Description_Forum; // Non null

    #[ORM\Column(length: 255)]
    private string $Createur_Forum; // Non null

    // Getters and Setters

    public function getIdForum(): int
    {
        return $this->Id_Forum;
    }

    public function setIdForum(int $Id_Forum): static
    {
        $this->Id_Forum = $Id_Forum;
        return $this;
    }

    public function getTitreForum(): string
    {
        return $this->Titre_Forum;
    }

    public function setTitreForum(string $Titre_Forum): static
    {
        $this->Titre_Forum = $Titre_Forum;
        return $this;
    }

    public function getDescriptionForum(): string
    {
        return $this->Description_Forum;
    }

    public function setDescriptionForum(string $Description_Forum): static
    {
        $this->Description_Forum = $Description_Forum;
        return $this;
    }

    public function getCreateurForum(): string
    {
        return $this->Createur_Forum;
    }

    public function setCreateurForum(string $Createur_Forum): static
    {
        $this->Createur_Forum = $Createur_Forum;
        return $this;
    }
}
