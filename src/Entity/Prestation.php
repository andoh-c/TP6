<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'prestation')]
class Prestation
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $libelle = null;

    #[ORM\Column(name: 'prix_unitaire', type: 'decimal', precision: 10, scale: 2)]
    private ?string $prixUnitaire = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'categorie_id', nullable: false)]
    private ?CategoriePrestation $categorie = null;

    public function getId(): ?int { return $this->id; }
    public function getLibelle(): ?string { return $this->libelle; }
    public function setLibelle(string $libelle): static { $this->libelle = $libelle; return $this; }
    public function getPrixUnitaire(): ?string { return $this->prixUnitaire; }
    public function setPrixUnitaire(string $prixUnitaire): static { $this->prixUnitaire = $prixUnitaire; return $this; }
    public function getCategorie(): ?CategoriePrestation { return $this->categorie; }
    public function setCategorie(?CategoriePrestation $categorie): static { $this->categorie = $categorie; return $this; }
    public function __toString(): string { return $this->libelle ?? ''; }
}
