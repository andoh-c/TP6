<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity]
#[ORM\Table(name: 'avancement_photo')]
#[Vich\Uploadable]
class AvancementPhoto
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Avancement $avancement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fichier = null;

    #[Vich\UploadableField(mapping: 'photos', fileNameProperty: 'fichier')]
    private ?File $fichierFile = null;

    public function getId(): ?int { return $this->id; }
    public function getAvancement(): ?Avancement { return $this->avancement; }
    public function setAvancement(?Avancement $avancement): static { $this->avancement = $avancement; return $this; }
    public function getFichier(): ?string { return $this->fichier; }
    public function setFichier(?string $fichier): static { $this->fichier = $fichier; return $this; }
    public function getFichierFile(): ?File { return $this->fichierFile; }
    public function setFichierFile(?File $file): void { $this->fichierFile = $file; }
}
