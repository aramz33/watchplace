<?php

namespace App\DataFixtures;

use App\Entity\Remontoire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Montre;
use App\Entity\Member;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $member = new Member();
        $member->setNom('Example Name');

        $manager->persist($member);

        $remontoire = new Remontoire();
        $remontoire->setId(1);
        $remontoire->setNom('Example Name');
        $remontoire->setMember($member);

        $manager->persist($remontoire);

        $montre = new Montre();
        $montre->setBrand('Example Brand');
        $montre->setRemontoireId($remontoire);

        $manager->persist($montre);


        $manager->flush();
    }
}
