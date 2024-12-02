<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ForumRepository;

#[ORM\Entity(repositoryClass: ForumRepository::class)]
class Forum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_forum", type: "integer")]
    private ?int $idForum = null;

    #[ORM\Column(name: "titre_forum", length: 255, nullable: false)]
    private string $titreForum;

    #[ORM\Column(name: "description_forum", type: "text", nullable: false)]
    private string $descriptionForum;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "createur_forum", referencedColumnName: "id_user")]
    private ?User $createurForum = null;

    #[ORM\OneToMany(mappedBy: "forum", targetEntity: MessageForum::class, cascade: ["persist", "remove"])]
    private Collection $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
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

   
}
