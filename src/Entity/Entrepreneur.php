<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EntrepreneurRepository;

#[ORM\Entity(repositoryClass: EntrepreneurRepository::class)]
#[ORM\Table(name: 'entrepreneur')]
class Entrepreneur
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nom = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(name: 'code_postal', length: 20, nullable: true)]
    private ?string $codePostal = null;

    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'categorie_id', nullable: false)]
    private ?CategorieEntrepreneur $categorie = null;

    #[ORM\ManyToMany(targetEntity: CategoriePrestation::class, fetch: 'EAGER')]
    #[ORM\JoinTable(name: 'entrepreneur_categorie_prestation',
        joinColumns: [new ORM\JoinColumn(name: 'entrepreneur_id')],
        inverseJoinColumns: [new ORM\JoinColumn(name: 'categorie_prestation_id')]
    )]
    private Collection $categoriesPrestations;

    public function __construct() { $this->categoriesPrestations = new ArrayCollection(); }

    public function getId(): ?int { return $this->id; }
    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): static { $this->nom = $nom; return $this; }
    public function getVille(): ?string { return $this->ville; }
    public function setVille(?string $ville): static { $this->ville = $ville; return $this; }
    public function getCodePostal(): ?string { return $this->codePostal; }
    public function setCodePostal(?string $codePostal): static { $this->codePostal = $codePostal; return $this; }
    public function getLatitude(): ?float { return $this->latitude; }
    public function setLatitude(?float $latitude): static { $this->latitude = $latitude; return $this; }
    public function getLongitude(): ?float { return $this->longitude; }
    public function setLongitude(?float $longitude): static { $this->longitude = $longitude; return $this; }
    public function getCategorie(): ?CategorieEntrepreneur { return $this->categorie; }
    public function setCategorie(?CategorieEntrepreneur $categorie): static { $this->categorie = $categorie; return $this; }
    public function getCategoriesPrestations(): Collection { return $this->categoriesPrestations; }
    public function __toString(): string { return $this->nom ?? ''; }
}
