<?php
namespace App\Controller;

use App\Entity\InspectionDocument;
use App\Entity\InspectionPhoto;
use App\Entity\Reception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/inspecteur')]
class InspecteurController extends AbstractController
{
    #[Route('', name: 'inspecteur_dashboard')]
    public function dashboard(EntityManagerInterface $em): Response
    {
        $inspecteur = $this->getUser()->getInspecteur();
        $chantiers = $inspecteur ? $em->getRepository(\App\Entity\Chantier::class)->findBy(['inspecteur' => $inspecteur]) : [];
        return $this->render('inspecteur/dashboard.html.twig', ['chantiers' => $chantiers]);
    }

    #[Route('/chantier/{id}', name: 'inspecteur_chantier')]
    public function chantier(int $id, EntityManagerInterface $em): Response
    {
        $chantier = $em->getRepository(\App\Entity\Chantier::class)->find($id);
        if (!$chantier) throw $this->createNotFoundException();
        $documents = $em->getRepository(InspectionDocument::class)->findBy(['chantier' => $chantier]);
        $photos = $em->getRepository(InspectionPhoto::class)->findBy(['chantier' => $chantier]);
        $reception = $em->getRepository(Reception::class)->findOneBy(['chantier' => $chantier]);
        return $this->render('inspecteur/chantier.html.twig', [
            'chantier' => $chantier, 'documents' => $documents, 'photos' => $photos, 'reception' => $reception,
        ]);
    }

    #[Route('/chantier/{id}/document', name: 'inspecteur_add_document', methods: ['POST'])]
    public function addDocument(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $chantier = $em->getRepository(\App\Entity\Chantier::class)->find($id);
        $doc = new InspectionDocument();
        $doc->setChantier($chantier);
        $doc->setType($request->request->get('type', 'autre'));
        $doc->setObservations($request->request->get('observations'));
        $file = $request->files->get('fichier');
        if ($file) $doc->setFichierFile($file);
        $em->persist($doc);
        $em->flush();
        $this->addFlash('success', 'Document ajouté.');
        return $this->redirectToRoute('inspecteur_chantier', ['id' => $id]);
    }

    #[Route('/chantier/{id}/photo', name: 'inspecteur_add_photo', methods: ['POST'])]
    public function addPhoto(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $chantier = $em->getRepository(\App\Entity\Chantier::class)->find($id);
        $photo = new InspectionPhoto();
        $photo->setChantier($chantier);
        $photo->setDescription($request->request->get('description'));
        $file = $request->files->get('fichier');
        if ($file) $photo->setFichierFile($file);
        $em->persist($photo);
        $em->flush();
        $this->addFlash('success', 'Photo ajoutée.');
        return $this->redirectToRoute('inspecteur_chantier', ['id' => $id]);
    }

    #[Route('/chantier/{id}/reception', name: 'inspecteur_reception', methods: ['POST'])]
    public function reception(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $chantier = $em->getRepository(\App\Entity\Chantier::class)->find($id);
        $reception = $em->getRepository(Reception::class)->findOneBy(['chantier' => $chantier]) ?? new Reception();
        $reception->setChantier($chantier);
        $reception->setDateReception(new \DateTime());
        $reception->setConforme($request->request->get('conforme') === '1');
        $reception->setReserves($request->request->get('reserves'));
        $chantier->setStatut('termine');
        $em->persist($reception);
        $em->flush();
        $this->addFlash('success', 'PV de réception enregistré.');
        return $this->redirectToRoute('inspecteur_chantier', ['id' => $id]);
    }
}
