<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'avancement')]
class Avancement
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chantier $chantier = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Entrepreneur $entrepreneur = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $pourcentage = 0;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(targetEntity: AvancementPhoto::class, mappedBy: 'avancement', cascade: ['persist', 'remove'])]
    private Collection $photos;

    public function __construct() { $this->createdAt = new \DateTime(); $this->photos = new ArrayCollection(); }

    public function getId(): ?int { return $this->id; }
    public function getChantier(): ?Chantier { return $this->chantier; }
    public function setChantier(?Chantier $chantier): static { $this->chantier = $chantier; return $this; }
    public function getEntrepreneur(): ?Entrepreneur { return $this->entrepreneur; }
    public function setEntrepreneur(?Entrepreneur $entrepreneur): static { $this->entrepreneur = $entrepreneur; return $this; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(string $description): static { $this->description = $description; return $this; }
    public function getPourcentage(): ?int { return $this->pourcentage; }
    public function setPourcentage(int $pourcentage): static { $this->pourcentage = $pourcentage; return $this; }
    public function getCreatedAt(): ?\DateTimeInterface { return $this->createdAt; }
    public function getPhotos(): Collection { return $this->photos; }
    public function addPhoto(AvancementPhoto $photo): static { if (!$this->photos->contains($photo)) { $this->photos->add($photo); $photo->setAvancement($this); } return $this; }
}
