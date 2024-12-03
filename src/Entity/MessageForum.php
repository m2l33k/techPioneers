<?php

namespace App\Entity;

use App\Repository\MessageForumRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageForumRepository::class)]
class MessageForum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $Id_MessageForum; // Non null

    #[ORM\Column(length: 255)]
    private string $Createur_MessageForum; // Non null

    #[ORM\Column]
    private int $Id_Forum; // Non null

    #[ORM\Column(type: 'text')]
    private string $Conetenu_Id_MessageForum; // Non null

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $DateCreation_Id_MessageForum; // Non null

    // Getters and Setters

    public function getIdMessageForum(): int
    {
        return $this->Id_MessageForum;
    }

    public function setIdMessageForum(int $Id_MessageForum): static
    {
        $this->Id_MessageForum = $Id_MessageForum;
        return $this;
    }

    public function getCreateurMessageForum(): string
    {
        return $this->Createur_MessageForum;
    }

    public function setCreateurMessageForum(string $Createur_MessageForum): static
    {
        $this->Createur_MessageForum = $Createur_MessageForum;
        return $this;
    }

    public function getIdForum(): int
    {
        return $this->Id_Forum;
    }

    public function setIdForum(int $Id_Forum): static
    {
        $this->Id_Forum = $Id_Forum;
        return $this;
    }

    public function getConetenuIdMessageForum(): string
    {
        return $this->Conetenu_Id_MessageForum;
    }

    public function setConetenuIdMessageForum(string $Conetenu_Id_MessageForum): static
    {
        $this->Conetenu_Id_MessageForum = $Conetenu_Id_MessageForum;
        return $this;
    }

    public function getDateCreationIdMessageForum(): \DateTimeInterface
    {
        return $this->DateCreation_Id_MessageForum;
    }

    public function setDateCreationIdMessageForum(\DateTimeInterface $DateCreation_Id_MessageForum): static
    {
        $this->DateCreation_Id_MessageForum = $DateCreation_Id_MessageForum;
        return $this;
    }
}
