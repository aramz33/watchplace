<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);

    }

    public function loadUsers(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$email, $plainPassword, $role]) {
            $user = new User();
            $user->setEmail($email);
            $user->setPassword($this->hasher->hashPassword($user, $plainPassword));
            $user->setRoles([$role]);

            $member = new Member();
            $member->setNom($email);
            $member->setUser($user);
            $user->setMember($member);

            $manager->persist($user);
            $manager->persist($member);
        }
        $manager->flush();
    }
    private function getUserData()
    {
        yield [
            'chris@localhost',
            'chris',
            'ROLE_USER'
        ];
        yield [
            'anna@localhost',
            'anna',
            'ROLE_ADMIN'
        ];
    }
}
