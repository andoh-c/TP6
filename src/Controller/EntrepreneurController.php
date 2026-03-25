<?php
namespace App\Controller;

use App\Entity\Avancement;
use App\Entity\AvancementPhoto;
use App\Entity\DevisEntrepreneur;
use App\Entity\PropositionChantier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/entrepreneur')]
class EntrepreneurController extends AbstractController
{
    #[Route('', name: 'entrepreneur_dashboard')]
    public function dashboard(EntityManagerInterface $em): Response
    {
        $entrepreneur = $this->getUser()->getEntrepreneur();
        $propositions = $entrepreneur
            ? $em->getRepository(PropositionChantier::class)->findBy(['entrepreneur' => $entrepreneur], ['createdAt' => 'DESC'])
            : [];
        return $this->render('entrepreneur/dashboard.html.twig', ['propositions' => $propositions]);
    }

    #[Route('/proposition/{id}', name: 'entrepreneur_proposition')]
    public function proposition(int $id, EntityManagerInterface $em): Response
    {
        $prop = $em->getRepository(PropositionChantier::class)->find($id);
        if (!$prop) throw $this->createNotFoundException();
        $devis = $em->getRepository(DevisEntrepreneur::class)->findOneBy(['proposition' => $prop]);
        $avancements = $em->getRepository(Avancement::class)->findBy(
            ['chantier' => $prop->getChantier(), 'entrepreneur' => $prop->getEntrepreneur()],
            ['createdAt' => 'DESC']
        );
        return $this->render('entrepreneur/proposition.html.twig', [
            'proposition' => $prop, 'devis' => $devis, 'avancements' => $avancements,
        ]);
    }

    #[Route('/proposition/{id}/repondre', name: 'entrepreneur_repondre', methods: ['POST'])]
    public function repondre(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $prop = $em->getRepository(PropositionChantier::class)->find($id);
        $action = $request->request->get('action');
        $prop->setStatut($action === 'accepter' ? PropositionChantier::STATUT_ACCEPTE : PropositionChantier::STATUT_REFUSE);
        $em->flush();
        $this->addFlash('success', 'Proposition ' . ($action === 'accepter' ? 'acceptée' : 'refusée') . '.');
        return $this->redirectToRoute('entrepreneur_proposition', ['id' => $id]);
    }

    #[Route('/proposition/{id}/devis', name: 'entrepreneur_soumettre_devis', methods: ['POST'])]
    public function soumettreDevis(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $prop = $em->getRepository(PropositionChantier::class)->find($id);
        $devis = new DevisEntrepreneur();
        $devis->setProposition($prop);
        $devis->setPrixTotal($request->request->get('prix_total'));
        $devis->setDateDebutTravaux(new \DateTime($request->request->get('date_debut')));
        $file = $request->files->get('fichier_pdf');
        if ($file) $devis->setFichierPdfFile($file);
        $prop->setStatut(PropositionChantier::STATUT_DEVIS_SOUMIS);
        $em->persist($devis);
        $em->flush();
        $this->addFlash('success', 'Devis soumis.');
        return $this->redirectToRoute('entrepreneur_proposition', ['id' => $id]);
    }

    #[Route('/proposition/{id}/avancement', name: 'entrepreneur_avancement', methods: ['POST'])]
    public function avancement(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $prop = $em->getRepository(PropositionChantier::class)->find($id);
        $av = new Avancement();
        $av->setChantier($prop->getChantier());
        $av->setEntrepreneur($prop->getEntrepreneur());
        $av->setDescription($request->request->get('description'));
        $av->setPourcentage((int)$request->request->get('pourcentage'));
        $file = $request->files->get('photo');
        if ($file) {
            $photo = new AvancementPhoto();
            $photo->setFichierFile($file);
            $av->addPhoto($photo);
        }
        $em->persist($av);
        $em->flush();
        $this->addFlash('success', 'Avancement mis à jour.');
        return $this->redirectToRoute('entrepreneur_proposition', ['id' => $id]);
    }
}
