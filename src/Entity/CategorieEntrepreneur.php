<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'categorie_entrepreneur')]
class CategorieEntrepreneur
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $libelle = null;

    public function getId(): ?int { return $this->id; }
    public function getLibelle(): ?string { return $this->libelle; }
    public function setLibelle(string $libelle): static { $this->libelle = $libelle; return $this; }
    public function __toString(): string { return $this->libelle ?? ''; }
}
