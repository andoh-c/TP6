<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BienRepository;

#[ORM\Entity(repositoryClass: BienRepository::class)]
#[ORM\Table(name: 'bien')]
class Bien
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 100)]
    private ?string $ville = null;

    #[ORM\Column(name: 'code_postal', length: 20)]
    private ?string $codePostal = null;

    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'proprietaire_id', nullable: false)]
    private ?Proprietaire $proprietaire = null;

    public function getId(): ?int { return $this->id; }
    public function getAdresse(): ?string { return $this->adresse; }
    public function setAdresse(string $adresse): static { $this->adresse = $adresse; return $this; }
    public function getVille(): ?string { return $this->ville; }
    public function setVille(string $ville): static { $this->ville = $ville; return $this; }
    public function getCodePostal(): ?string { return $this->codePostal; }
    public function setCodePostal(string $codePostal): static { $this->codePostal = $codePostal; return $this; }
    public function getLatitude(): ?float { return $this->latitude; }
    public function setLatitude(?float $latitude): static { $this->latitude = $latitude; return $this; }
    public function getLongitude(): ?float { return $this->longitude; }
    public function setLongitude(?float $longitude): static { $this->longitude = $longitude; return $this; }
    public function getProprietaire(): ?Proprietaire { return $this->proprietaire; }
    public function setProprietaire(?Proprietaire $proprietaire): static { $this->proprietaire = $proprietaire; return $this; }
    public function __toString(): string { return $this->adresse . ', ' . $this->codePostal . ' ' . $this->ville; }
}
