<?php

namespace App\Entity;

use App\Repository\ForumRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
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

    #[ORM\Column(name: "createur_forum", length: 255, nullable: false)]
    private string $createurForum;

    public function getIdForum(): ?int
    {
        return $this->idForum;
    }

    public function getTitreForum(): string
    {
        return $this->titreForum;
    }

    public function getDescriptionForum(): string
    {
        return $this->descriptionForum;
    }

    public function getCreateurForum(): string
    {
        return $this->createurForum;
    }
}
