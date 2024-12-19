<?php


namespace App\Entity;


use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\ManyToOne(targetEntity: Category::class)]
#[ORM\JoinColumn(name: "category_id", referencedColumnName: "idCategory")]
private ?Category $category = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le nom de l'événement est obligatoire.")]
    #[Assert\Length(
        max: 50,
        maxMessage: "Le nom de l'événement ne doit pas dépasser {{ limit }} caractères."
    )]
    private ?string $EventName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE,nullable: true)]


    private ?\DateTimeInterface $EventDate = null;



    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La description de l'événement est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "La description de l'événement ne doit pas dépasser {{ limit }} caractères."
    )]
    private ?string $EventDesc = null;

    #[ORM\Column(nullable: true)]
    private ?string $TypeEvenement = null;



    /**
     * @var Collection<int, Projet>
     */
    #[ORM\OneToMany(targetEntity: Projet::class, mappedBy: 'evenement')]
    private Collection $projets;

    #[ORM\Column(nullable: true)]
    private ?int $nbProjet = null;

    #[ORM\Column(nullable: true)]
    private ?int $capacite = null;

    /**
     * @var Collection<int, SubscriptionEvent>
     */
    #[ORM\OneToMany(targetEntity: SubscriptionEvent::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $subscriptionEvents;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le lieu de l'événement est obligatoire.")]
    #[Assert\Length(
        max: 50,
        maxMessage: "Le lieu de l'événement ne doit pas dépasser {{ limit }} caractères."
    )]
    private ?string $EventPlace = null;



    public function __construct()
    {

        $this->projets = new ArrayCollection();
        $this->subscriptionEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventName(): ?string
    {
        return $this->EventName;
    }

    public function setEventName(string $EventName): static
    {
        $this->EventName = $EventName;
        return $this;
    }

    public function getEventDate(): ?\DateTimeInterface
    {
        return $this->EventDate;
    }

    public function setEventDate(\DateTimeInterface $EventDate): static
    {
        $this->EventDate = $EventDate;
        return $this;
    }



    public function getEventDesc(): ?string
    {
        return $this->EventDesc;
    }

    public function setEventDesc(string $EventDesc): static
    {
        $this->EventDesc = $EventDesc;
        return $this;
    }

    public function getTypeEvenement(): ?string
    {
        return $this->TypeEvenement;
    }

    public function setTypeEvenement(?string $TypeEvenement): static
    {
        $this->TypeEvenement = $TypeEvenement;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }
    
    public function setCategory(?Category $category): static
    {
        $this->category = $category;
        return $this;
    }
    /**
     * @return Collection<int, Projet>
     */
    public function getProjets() : Collection
    {
        return $this->projets;
    }

    public function addProjet(Projet $projet): static
    {
        if (!$this->projets->contains($projet)) {
            $this->projets->add($projet);
            $projet->setEvenement($this);
        }
        return $this;
    }

    public function removeProjet(Projet $projet): static
    {
        if ($this->projets->removeElement($projet)) {
            // set the owning side to null (unless already changed)
            if ($projet->getEvenement() === $this) {
                $projet->setEvenement(null);
            }
        }
        return $this;
    }

    public function getNbProjet(): ?int
    {
        return $this->nbProjet;
    }

    public function setNbProjet(?int $nbProjet): static
    {
        $this->nbProjet = $nbProjet;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    /**
     * @return Collection<int, SubscriptionEvent>
     */
    public function getSubscriptionEvents(): Collection
    {
        return $this->subscriptionEvents;
    }

    public function addSubscriptionEvent(SubscriptionEvent $subscriptionEvent): static
    {
        if (!$this->subscriptionEvents->contains($subscriptionEvent)) {
            $this->subscriptionEvents->add($subscriptionEvent);
            $subscriptionEvent->setEvent($this);
        }

        return $this;
    }

    public function removeSubscriptionEvent(SubscriptionEvent $subscriptionEvent): static
    {
        if ($this->subscriptionEvents->removeElement($subscriptionEvent)) {
            // set the owning side to null (unless already changed)
            if ($subscriptionEvent->getEvent() === $this) {
                $subscriptionEvent->setEvent(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getEventPlace(): ?string
    {
        return $this->EventPlace;
    }

    public function setEventPlace(string $EventPlace): static
    {
        $this->EventPlace = $EventPlace;
        return $this;
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return $this->EventName;
    }

}
