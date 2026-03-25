<?php
namespace App\Controller;

use App\Entity\Bien;
use App\Entity\Chantier;
use App\Entity\InspectionDocument;
use App\Entity\InspectionPhoto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/proprietaire')]
class ProprietaireController extends AbstractController
{
    #[Route('', name: 'proprietaire_dashboard')]
    public function dashboard(EntityManagerInterface $em): Response
    {
        $proprietaire = $this->getUser()->getProprietaire();
        $biens = $proprietaire ? $em->getRepository(Bien::class)->findBy(['proprietaire' => $proprietaire]) : [];
        $chantiers = $proprietaire
            ? $em->createQuery('SELECT c FROM App\Entity\Chantier c JOIN c.bien b WHERE b.proprietaire = :p')
                ->setParameter('p', $proprietaire)->getResult()
            : [];
        return $this->render('proprietaire/dashboard.html.twig', ['biens' => $biens, 'chantiers' => $chantiers]);
    }

    #[Route('/chantier/{id}', name: 'proprietaire_chantier')]
    public function chantier(int $id, EntityManagerInterface $em): Response
    {
        $chantier = $em->getRepository(Chantier::class)->find($id);
        if (!$chantier) throw $this->createNotFoundException();
        $documents = $em->getRepository(InspectionDocument::class)->findBy(['chantier' => $chantier]);
        $photos = $em->getRepository(InspectionPhoto::class)->findBy(['chantier' => $chantier]);
        return $this->render('proprietaire/chantier.html.twig', [
            'chantier' => $chantier, 'documents' => $documents, 'photos' => $photos,
        ]);
    }

    #[Route('/chantier/{id}/valider', name: 'proprietaire_valider', methods: ['POST'])]
    public function valider(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $chantier = $em->getRepository(Chantier::class)->find($id);
        $action = $request->request->get('action');
        $chantier->setStatut($action === 'accepter' ? 'valide' : 'refuse');
        $em->flush();
        $this->addFlash('success', 'Chantier ' . ($action === 'accepter' ? 'validé' : 'refusé') . '.');
        return $this->redirectToRoute('proprietaire_chantier', ['id' => $id]);
    }
}
