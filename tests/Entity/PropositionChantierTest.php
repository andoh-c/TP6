<?php
namespace App\Tests\Entity;

use App\Entity\PropositionChantier;
use PHPUnit\Framework\TestCase;

class PropositionChantierTest extends TestCase
{
    public function testDefaultStatut(): void
    {
        $p = new PropositionChantier();
        $this->assertEquals('envoye', $p->getStatut());
    }

    public function testCreatedAtIsSet(): void
    {
        $p = new PropositionChantier();
        $this->assertInstanceOf(\DateTimeInterface::class, $p->getCreatedAt());
    }

    public function testStatutConstants(): void
    {
        $this->assertEquals('envoye', PropositionChantier::STATUT_ENVOYE);
        $this->assertEquals('accepte', PropositionChantier::STATUT_ACCEPTE);
        $this->assertEquals('refuse', PropositionChantier::STATUT_REFUSE);
        $this->assertEquals('devis_soumis', PropositionChantier::STATUT_DEVIS_SOUMIS);
    }
}
