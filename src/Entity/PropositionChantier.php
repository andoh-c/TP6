<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PropositionChantierRepository;

#[ORM\Entity(repositoryClass: PropositionChantierRepository::class)]
#[ORM\Table(name: 'proposition_chantier')]
class PropositionChantier
{
    public const STATUT_ENVOYE = 'envoye';
    public const STATUT_ACCEPTE = 'accepte';
    public const STATUT_REFUSE = 'refuse';
    public const STATUT_DEVIS_SOUMIS = 'devis_soumis';

    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chantier $chantier = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Entrepreneur $entrepreneur = null;

    #[ORM\Column(length: 30)]
    private ?string $statut = self::STATUT_ENVOYE;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    public function __construct() { $this->createdAt = new \DateTime(); }

    public function getId(): ?int { return $this->id; }
    public function getChantier(): ?Chantier { return $this->chantier; }
    public function setChantier(?Chantier $chantier): static { $this->chantier = $chantier; return $this; }
    public function getEntrepreneur(): ?Entrepreneur { return $this->entrepreneur; }
    public function setEntrepreneur(?Entrepreneur $entrepreneur): static { $this->entrepreneur = $entrepreneur; return $this; }
    public function getStatut(): ?string { return $this->statut; }
    public function setStatut(string $statut): static { $this->statut = $statut; return $this; }
    public function getCreatedAt(): ?\DateTimeInterface { return $this->createdAt; }
}
