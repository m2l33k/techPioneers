<?php
namespace App\Entity;

use App\Repository\MessageForumRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Forum;

#[ORM\Entity(repositoryClass: MessageForumRepository::class)]
class MessageForum
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private $IdMessageForum;

   // Define the relation with the User entity (ManyToOne)
   #[ORM\ManyToOne(targetEntity: User::class)]
   #[ORM\JoinColumn(name: 'CreateurMessageForum', referencedColumnName: 'id_user')]
   private ?User $CreateurMessageForum; 

    // No need for 'id_forum' property explicitly in the entity
    #[ORM\ManyToOne(targetEntity: Forum::class, inversedBy: 'messages')]
    #[ORM\JoinColumn(name: 'id_forum', referencedColumnName: 'id_forum', nullable: true)]
    private ?Forum $forum;

    #[ORM\Column(type: 'text')]
    private string $ConetenuIdMessageForum;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $DateCreationIdMessageForum;

    // Getters and Setters

    public function getIdMessageForum(): ?int
{
    return $this->IdMessageForum;
}

    public function setIdMessageForum(int $Id_MessageForum): static
    {
        $this->IdMessageForum = $Id_MessageForum;
        return $this;
    }

    public function getCreateurMessageForum(): User
    {
        return $this->CreateurMessageForum;
    }

    public function setCreateurMessageForum(User $Createur_MessageForum): static
    {
        $this->CreateurMessageForum = $Createur_MessageForum;
        return $this;
    }

    // Getters and Setters for Forum (the association with Forum)
    public function getForum(): ?Forum
    {
        return $this->forum;
    }

    public function setForum(?Forum $forum): static
    {
        $this->forum = $forum;
        return $this;
    }

    public function getConetenuIdMessageForum(): string
    {
        return $this->ConetenuIdMessageForum;
    }

    public function setConetenuIdMessageForum(string $Conetenu_Id_MessageForum): static
    {
        $this->ConetenuIdMessageForum = $Conetenu_Id_MessageForum;
        return $this;
    }

    public function getDateCreationIdMessageForum(): \DateTimeInterface
    {
        return $this->DateCreationIdMessageForum;
    }

    public function setDateCreationIdMessageForum(\DateTimeInterface $DateCreation_Id_MessageForum): static
    {
        $this->DateCreationIdMessageForum = $DateCreation_Id_MessageForum;
        return $this;
    }
}
