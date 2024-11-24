<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\Table(name: '`admin`')]
#[Broadcast]
class Admin extends User
{
    #[ORM\Column(length: 255)]
    private ?string $Post_Admin = null;

    public function getPostAdmin(): ?string
    {
        return $this->Post_Admin;
    }

    public function setPostAdmin(string $Post_Admin): static
    {
        $this->Post_Admin = $Post_Admin;
        return $this;
    }
}
