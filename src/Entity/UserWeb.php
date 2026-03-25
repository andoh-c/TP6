<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserWebRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserWebRepository::class)]
#[ORM\Table(name: 'user_web')]
class UserWeb implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Inspecteur $inspecteur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Entrepreneur $entrepreneur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Proprietaire $proprietaire = null;

    public function getId(): ?int { return $this->id; }
    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }
    public function getUserIdentifier(): string { return (string) $this->email; }
    public function getRoles(): array { $roles = $this->roles; $roles[] = 'ROLE_USER'; return array_unique($roles); }
    public function setRoles(array $roles): static { $this->roles = $roles; return $this; }
    public function getPassword(): ?string { return $this->password; }
    public function setPassword(string $password): static { $this->password = $password; return $this; }
    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): static { $this->nom = $nom; return $this; }
    public function getInspecteur(): ?Inspecteur { return $this->inspecteur; }
    public function setInspecteur(?Inspecteur $inspecteur): static { $this->inspecteur = $inspecteur; return $this; }
    public function getEntrepreneur(): ?Entrepreneur { return $this->entrepreneur; }
    public function setEntrepreneur(?Entrepreneur $entrepreneur): static { $this->entrepreneur = $entrepreneur; return $this; }
    public function getProprietaire(): ?Proprietaire { return $this->proprietaire; }
    public function setProprietaire(?Proprietaire $proprietaire): static { $this->proprietaire = $proprietaire; return $this; }
    public function eraseCredentials(): void {}
    public function __toString(): string { return $this->nom ?? $this->email ?? ''; }
}
