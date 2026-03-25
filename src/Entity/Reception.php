<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'reception')]
class Reception
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chantier $chantier = null;

    #[ORM\Column(name: 'date_reception', type: 'date')]
    private ?\DateTimeInterface $dateReception = null;

    #[ORM\Column]
    private ?bool $conforme = false;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $reserves = null;

    #[ORM\Column(name: 'fichier_pv', length: 255, nullable: true)]
    private ?string $fichierPv = null;

    public function getId(): ?int { return $this->id; }
    public function getChantier(): ?Chantier { return $this->chantier; }
    public function setChantier(?Chantier $chantier): static { $this->chantier = $chantier; return $this; }
    public function getDateReception(): ?\DateTimeInterface { return $this->dateReception; }
    public function setDateReception(\DateTimeInterface $date): static { $this->dateReception = $date; return $this; }
    public function isConforme(): ?bool { return $this->conforme; }
    public function setConforme(bool $conforme): static { $this->conforme = $conforme; return $this; }
    public function getReserves(): ?string { return $this->reserves; }
    public function setReserves(?string $reserves): static { $this->reserves = $reserves; return $this; }
    public function getFichierPv(): ?string { return $this->fichierPv; }
    public function setFichierPv(?string $fichierPv): static { $this->fichierPv = $fichierPv; return $this; }
}
