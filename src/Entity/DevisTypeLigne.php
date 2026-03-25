<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'devis_type_ligne')]
class DevisTypeLigne
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'lignesDevis')]
    #[ORM\JoinColumn(name: 'chantier_id', nullable: false)]
    private ?Chantier $chantier = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'prestation_id', nullable: false)]
    private ?Prestation $prestation = null;

    #[ORM\Column]
    private ?int $quantite = null;

    public function getId(): ?int { return $this->id; }
    public function getChantier(): ?Chantier { return $this->chantier; }
    public function setChantier(?Chantier $chantier): static { $this->chantier = $chantier; return $this; }
    public function getPrestation(): ?Prestation { return $this->prestation; }
    public function setPrestation(?Prestation $prestation): static { $this->prestation = $prestation; return $this; }
    public function getQuantite(): ?int { return $this->quantite; }
    public function setQuantite(int $quantite): static { $this->quantite = $quantite; return $this; }
}
