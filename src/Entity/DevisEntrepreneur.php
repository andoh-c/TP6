<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity]
#[ORM\Table(name: 'devis_entrepreneur')]
#[Vich\Uploadable]
class DevisEntrepreneur
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne]
    #[ORM\JoinColumn(name: 'proposition_id', nullable: false)]
    private ?PropositionChantier $proposition = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fichierPdf = null;

    #[Vich\UploadableField(mapping: 'devis', fileNameProperty: 'fichierPdf')]
    private ?File $fichierPdfFile = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?string $prixTotal = null;

    #[ORM\Column(name: 'date_debut_travaux', type: 'date')]
    private ?\DateTimeInterface $dateDebutTravaux = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    public function __construct() { $this->createdAt = new \DateTime(); }

    public function getId(): ?int { return $this->id; }
    public function getProposition(): ?PropositionChantier { return $this->proposition; }
    public function setProposition(?PropositionChantier $proposition): static { $this->proposition = $proposition; return $this; }
    public function getFichierPdf(): ?string { return $this->fichierPdf; }
    public function setFichierPdf(?string $fichierPdf): static { $this->fichierPdf = $fichierPdf; return $this; }
    public function getFichierPdfFile(): ?File { return $this->fichierPdfFile; }
    public function setFichierPdfFile(?File $file): void { $this->fichierPdfFile = $file; if ($file) { $this->createdAt = new \DateTime(); } }
    public function getPrixTotal(): ?string { return $this->prixTotal; }
    public function setPrixTotal(string $prixTotal): static { $this->prixTotal = $prixTotal; return $this; }
    public function getDateDebutTravaux(): ?\DateTimeInterface { return $this->dateDebutTravaux; }
    public function setDateDebutTravaux(\DateTimeInterface $date): static { $this->dateDebutTravaux = $date; return $this; }
    public function getCreatedAt(): ?\DateTimeInterface { return $this->createdAt; }
}
