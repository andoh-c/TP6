<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity]
#[ORM\Table(name: 'inspection_document')]
#[Vich\Uploadable]
class InspectionDocument
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chantier $chantier = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null; // DPE, diagnostic_bruit, autre

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fichier = null;

    #[Vich\UploadableField(mapping: 'documents', fileNameProperty: 'fichier')]
    private ?File $fichierFile = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $observations = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    public function __construct() { $this->createdAt = new \DateTime(); }

    public function getId(): ?int { return $this->id; }
    public function getChantier(): ?Chantier { return $this->chantier; }
    public function setChantier(?Chantier $chantier): static { $this->chantier = $chantier; return $this; }
    public function getType(): ?string { return $this->type; }
    public function setType(string $type): static { $this->type = $type; return $this; }
    public function getFichier(): ?string { return $this->fichier; }
    public function setFichier(?string $fichier): static { $this->fichier = $fichier; return $this; }
    public function getFichierFile(): ?File { return $this->fichierFile; }
    public function setFichierFile(?File $fichierFile): void { $this->fichierFile = $fichierFile; if ($fichierFile) { $this->createdAt = new \DateTime(); } }
    public function getObservations(): ?string { return $this->observations; }
    public function setObservations(?string $observations): static { $this->observations = $observations; return $this; }
    public function getCreatedAt(): ?\DateTimeInterface { return $this->createdAt; }
}
