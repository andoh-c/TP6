<?php
namespace App\DataFixtures;

use App\Entity\UserWeb;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
        $users = [
            ['admin@gesttravaux.fr', 'Admin', ['ROLE_ADMIN'], 'admin123', null, null, null],
            ['julie.martin@example.com', 'Martin Julie', ['ROLE_INSPECTEUR'], 'inspecteur123', 1, null, null],
            ['dupont@btp.fr', 'Dupont BTP', ['ROLE_ENTREPRENEUR'], 'entrepreneur123', null, 1, null],
            ['paul.durand@example.com', 'Durand Paul', ['ROLE_PROPRIETAIRE'], 'proprietaire123', null, null, 1],
        ];

        foreach ($users as [$email, $nom, $roles, $password, $inspId, $entrId, $propId]) {
            $user = new UserWeb();
            $user->setEmail($email)->setNom($nom)->setRoles($roles);
            $user->setPassword($this->hasher->hashPassword($user, $password));
            if ($inspId) $user->setInspecteur($manager->getReference(\App\Entity\Inspecteur::class, $inspId));
            if ($entrId) $user->setEntrepreneur($manager->getReference(\App\Entity\Entrepreneur::class, $entrId));
            if ($propId) $user->setProprietaire($manager->getReference(\App\Entity\Proprietaire::class, $propId));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
