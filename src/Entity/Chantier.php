<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ChantierRepository;

#[ORM\Entity(repositoryClass: ChantierRepository::class)]
#[ORM\Table(name: 'chantier')]
class Chantier
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $libelle = null;

    #[ORM\Column(name: 'date_creation', type: 'date')]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(length: 30, nullable: true, options: ['default' => 'cree'])]
    private ?string $statut = 'cree';

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'bien_id', nullable: false)]
    private ?Bien $bien = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'inspecteur_id', nullable: false)]
    private ?Inspecteur $inspecteur = null;

    #[ORM\OneToMany(targetEntity: DevisTypeLigne::class, mappedBy: 'chantier')]
    private Collection $lignesDevis;

    public function __construct() { $this->lignesDevis = new ArrayCollection(); }

    public function getId(): ?int { return $this->id; }
    public function getLibelle(): ?string { return $this->libelle; }
    public function setLibelle(string $libelle): static { $this->libelle = $libelle; return $this; }
    public function getDateCreation(): ?\DateTimeInterface { return $this->dateCreation; }
    public function setDateCreation(\DateTimeInterface $dateCreation): static { $this->dateCreation = $dateCreation; return $this; }
    public function getStatut(): ?string { return $this->statut; }
    public function setStatut(?string $statut): static { $this->statut = $statut; return $this; }
    public function getBien(): ?Bien { return $this->bien; }
    public function setBien(?Bien $bien): static { $this->bien = $bien; return $this; }
    public function getInspecteur(): ?Inspecteur { return $this->inspecteur; }
    public function setInspecteur(?Inspecteur $inspecteur): static { $this->inspecteur = $inspecteur; return $this; }
    public function getLignesDevis(): Collection { return $this->lignesDevis; }
    public function __toString(): string { return $this->libelle ?? ''; }
}
