<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginPageIsAccessible(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Connexion');
    }

    public function testHomeRedirectsToLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseRedirects('/login');
    }

    public function testAdminRequiresAuth(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin/chantiers');
        $this->assertResponseRedirects('/login');
    }

    public function testInspecteurRequiresAuth(): void
    {
        $client = static::createClient();
        $client->request('GET', '/inspecteur');
        $this->assertResponseRedirects('/login');
    }

    public function testEntrepreneurRequiresAuth(): void
    {
        $client = static::createClient();
        $client->request('GET', '/entrepreneur');
        $this->assertResponseRedirects('/login');
    }

    public function testProprietaireRequiresAuth(): void
    {
        $client = static::createClient();
        $client->request('GET', '/proprietaire');
        $this->assertResponseRedirects('/login');
    }
}
