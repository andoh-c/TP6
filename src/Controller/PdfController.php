<?php
namespace App\Controller;

use App\Entity\Chantier;
use App\Entity\Reception;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PdfController extends AbstractController
{
    #[Route('/inspecteur/chantier/{id}/pv-pdf', name: 'inspecteur_pv_pdf')]
    public function pvPdf(int $id, EntityManagerInterface $em): Response
    {
        $chantier = $em->getRepository(Chantier::class)->find($id);
        $reception = $em->getRepository(Reception::class)->findOneBy(['chantier' => $chantier]);
        if (!$reception) throw $this->createNotFoundException('Pas de réception pour ce chantier.');

        $html = $this->renderView('pdf/pv_reception.html.twig', [
            'chantier' => $chantier, 'reception' => $reception,
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();

        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="PV_reception_' . $chantier->getId() . '.pdf"',
        ]);
    }
}
