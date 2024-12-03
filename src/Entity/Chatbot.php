<?php

namespace App\Entity;

use App\Repository\ChatbotRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatbotRepository::class)]
class Chatbot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $Id_Chatbot; // Identifiant non null

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $Datecreation_Chatbot; // Non null

    #[ORM\Column(type: 'text')]
    private string $Contenu_Chatbot; // Non null

    #[ORM\Column]
    private int $Autheur_Chatbot; // Non null

    // Getters and Setters

    public function getIdChatbot(): int
    {
        return $this->Id_Chatbot;
    }

    public function setIdChatbot(int $Id_Chatbot): static
    {
        $this->Id_Chatbot = $Id_Chatbot;
        return $this;
    }

    public function getDatecreationChatbot(): \DateTimeInterface
    {
        return $this->Datecreation_Chatbot;
    }

    public function setDatecreationChatbot(\DateTimeInterface $Datecreation_Chatbot): static
    {
        $this->Datecreation_Chatbot = $Datecreation_Chatbot;
        return $this;
    }

    public function getContenuChatbot(): string
    {
        return $this->Contenu_Chatbot;
    }

    public function setContenuChatbot(string $Contenu_Chatbot): static
    {
        $this->Contenu_Chatbot = $Contenu_Chatbot;
        return $this;
    }

    public function getAutheurChatbot(): int
    {
        return $this->Autheur_Chatbot;
    }

    public function setAutheurChatbot(int $Autheur_Chatbot): static
    {
        $this->Autheur_Chatbot = $Autheur_Chatbot;
        return $this;
    }
}
