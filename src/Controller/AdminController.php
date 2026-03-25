<?php
namespace App\Controller;

use App\Entity\Chantier;
use App\Entity\Entrepreneur;
use App\Entity\PropositionChantier;
use App\Entity\UserWeb;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/chantiers', name: 'admin_chantiers')]
    public function chantiers(EntityManagerInterface $em): Response
    {
        $chantiers = $em->getRepository(Chantier::class)->findAll();
        $stats = [
            'total' => count($chantiers),
            'en_cours' => count(array_filter($chantiers, fn($c) => !in_array($c->getStatut(), ['termine', 'refuse']))),
            'termines' => count(array_filter($chantiers, fn($c) => $c->getStatut() === 'termine')),
            'entrepreneurs' => count($em->getRepository(Entrepreneur::class)->findAll()),
            'propositions' => count($em->getRepository(PropositionChantier::class)->findAll()),
        ];
        return $this->render('admin/chantiers.html.twig', ['chantiers' => $chantiers, 'stats' => $stats]);
    }

    #[Route('/users', name: 'admin_users')]
    public function users(EntityManagerInterface $em): Response
    {
        return $this->render('admin/users.html.twig', ['users' => $em->getRepository(UserWeb::class)->findAll()]);
    }

    #[Route('/users/new', name: 'admin_user_new', methods: ['POST'])]
    public function newUser(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $user = new UserWeb();
        $user->setEmail($request->request->get('email'));
        $user->setNom($request->request->get('nom'));
        $user->setRoles([$request->request->get('role')]);
        $user->setPassword($hasher->hashPassword($user, $request->request->get('password')));

        // Link to entity if applicable
        $role = $request->request->get('role');
        $entityId = $request->request->get('entity_id');
        if ($entityId) {
            if ($role === 'ROLE_INSPECTEUR') $user->setInspecteur($em->getReference(\App\Entity\Inspecteur::class, $entityId));
            if ($role === 'ROLE_ENTREPRENEUR') $user->setEntrepreneur($em->getReference(\App\Entity\Entrepreneur::class, $entityId));
            if ($role === 'ROLE_PROPRIETAIRE') $user->setProprietaire($em->getReference(\App\Entity\Proprietaire::class, $entityId));
        }

        $em->persist($user);
        $em->flush();
        $this->addFlash('success', 'Utilisateur créé.');
        return $this->redirectToRoute('admin_users');
    }

    #[Route('/users/{id}/delete', name: 'admin_user_delete', methods: ['POST'])]
    public function deleteUser(int $id, EntityManagerInterface $em): Response
    {
        $user = $em->getRepository(UserWeb::class)->find($id);
        if ($user) { $em->remove($user); $em->flush(); }
        $this->addFlash('success', 'Utilisateur supprimé.');
        return $this->redirectToRoute('admin_users');
    }
}
