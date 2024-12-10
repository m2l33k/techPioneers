<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ForumRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ForumRepository::class)]
class Forum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_forum", type: "integer")]
    private ?int $idForum = null;

    #[ORM\Column(name: "titre_forum", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "The title cannot be empty.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "The title cannot exceed {{ limit }} characters."
    )]
    private string $titreForum;

    #[ORM\Column(name: "description_forum", type: "text", nullable: false)]
    #[Assert\NotBlank(message: "The description cannot be empty.")]
    #[Assert\Length(
        min: 5,
        minMessage: "The description must contain at least {{ limit }} characters."
    )]
    private string $descriptionForum;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "createur_forum", referencedColumnName: "id_user")]
    #[Assert\NotNull(message: "Please select a creator for the forum.")]
    private ?User $createurForum = null;


    #[ORM\OneToMany(mappedBy: "forum", targetEntity: MessageForum::class, cascade: ["persist", "remove"])]
    private Collection $messages;

    #[ORM\Column(type: 'datetime')]
private \DateTimeInterface $createdAt;

public function __construct()
{
    $this->messages = new ArrayCollection();
    $this->createdAt = new \DateTime(); // Set the current date and time
}


    public function getIdForum(): ?int
    {
        return $this->idForum;
    }

    public function getTitreForum(): string
    {
        return $this->titreForum;
    }

    public function setTitreForum(string $titreForum): self
    {
        $this->titreForum = $titreForum;
        return $this;
    }

    public function getDescriptionForum(): string
    {
        return $this->descriptionForum;
    }

    public function setDescriptionForum(string $descriptionForum): self
    {
        $this->descriptionForum = $descriptionForum;
        return $this;
    }

    public function getCreateurForum(): ?User
    {
        return $this->createurForum;
    }
    
    public function setCreateurForum(?User $createurForum): self
    {
        $this->createurForum = $createurForum;
        return $this;
    }
    

    /**
     * @return Collection<int, MessageForum>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(MessageForum $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setForum($this);
        }

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
{
    return $this->createdAt;
}

public function setCreatedAt(\DateTimeInterface $createdAt): self
{
    $this->createdAt = $createdAt;
    return $this;
}

   
}
