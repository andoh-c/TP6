<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authUtils): Response
    {
        if ($this->getUser()) return $this->redirectToRoute('app_home');
        return $this->render('security/login.html.twig', [
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void {}

    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) return $this->redirectToRoute('admin_chantiers');
        if ($this->isGranted('ROLE_INSPECTEUR')) return $this->redirectToRoute('inspecteur_dashboard');
        if ($this->isGranted('ROLE_ENTREPRENEUR')) return $this->redirectToRoute('entrepreneur_dashboard');
        if ($this->isGranted('ROLE_PROPRIETAIRE')) return $this->redirectToRoute('proprietaire_dashboard');
        return $this->redirectToRoute('app_login');
    }
}
