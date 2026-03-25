<?php
namespace App\Tests\Entity;

use App\Entity\UserWeb;
use PHPUnit\Framework\TestCase;

class UserWebTest extends TestCase
{
    public function testRolesAlwaysContainRoleUser(): void
    {
        $user = new UserWeb();
        $user->setRoles(['ROLE_ADMIN']);
        $this->assertContains('ROLE_USER', $user->getRoles());
        $this->assertContains('ROLE_ADMIN', $user->getRoles());
    }

    public function testUserIdentifier(): void
    {
        $user = new UserWeb();
        $user->setEmail('test@test.com');
        $this->assertEquals('test@test.com', $user->getUserIdentifier());
    }

    public function testSettersReturnStatic(): void
    {
        $user = new UserWeb();
        $this->assertSame($user, $user->setEmail('a@b.com'));
        $this->assertSame($user, $user->setNom('Test'));
        $this->assertSame($user, $user->setPassword('hash'));
    }

    public function testToString(): void
    {
        $user = new UserWeb();
        $user->setNom('Admin');
        $this->assertEquals('Admin', (string) $user);
    }
}
